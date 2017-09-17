<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 01/08/2017
 * Time: 14:36
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product as ProductModel;
use app\api\model\Product;
use app\api\model\Order as OrderModel;
use app\lib\exception\ProductMiss;
use think\Db;

class Order
{
    const OrderUnpaid = 1;
    const OrderPaid = 2;
    const OrderDelivering = 3;
    const OrderLackStock = 4;
    const OrderDelivered = 5;
    protected $products; // 订单商品
    protected $warehouse; // 商品库存
    protected $uid; // 用户ID
    protected $address; // 收货地址

    /**
     *  创建订单
     * @param $uid
     * @param $order
     * @return array
     */
    public function create($uid,$order){
        $this->products = $order['products'];
        $this->address = $order['address'];
        $this->uid = $uid;

        // 根据提交获取库存
        $this->warehouse = $this->getWarehouse($order['products']);
        // 检查订单库存
        $orderInfo = $this->getOrderStatus($this->products, $this->warehouse);

        if( !$orderInfo['pass'] ){
            $orderInfo['id'] = -1;
            return $orderInfo;
        }

        $order = $this->createOrder($orderInfo);

        return $order;
    }

    /**
     * 订单写入数据库
     * @param $orderInfo
     * @return OrderModel
     * @throws \Exception
     */
    private function createOrder($orderInfo){
        Db::startTrans();
        try {
            $snap = $this->snapOrder($orderInfo);
            $snap['order_no'] = $this->makeOrderNo();
            $snap['user_id'] = $this->uid;
            $snap['status'] = self::OrderUnpaid;
            $snap['snap_address'] = json_encode($this->address);

            $order = new OrderModel();
            $order->data($snap);
            $order->save();

            $data = [];
            foreach ($this->products as $product) {
                $temp['order_id'] = $order->id;
                $temp['product_id'] = $product['id'];
                $temp['count'] = $product['count'];
                $data[] = $temp;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($data);

            Db::commit();
        }catch(\Exception $e){
            Db::rollback();
            throw $e;
        }

        return $order;
    }

    /**
     * 生成订单号
     * @return string
     */
    public static function makeOrderNo(){
        $yearCode = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];
        $orderSn = $yearCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m')))
            . date('d') . substr(time(), -5) . substr(microtime(), 2, 5)
            . sprintf('%02d',rand(0,99));
        return $orderSn;
    }

    private function snapOrder($orderInfo){
        $snap= [];
        $products_status = $orderInfo['products_status'];
        $snap['snap_img'] = $products_status[0]['main_img_url'];
        $snap['snap_name'] = $products_status[0]['name'];
        $snap['total_count'] = $orderInfo['total_count'];
        $snap['snap_items'] = json_encode($products_status);
        $snap['total_price'] = $orderInfo['total_price'];

        if( count($products_status) > 1 ){
            $snap['snap_name'] .= '等 ';
        }

        return $snap;
    }

    /**
     * 检查库存，获取订单状态
     * @param $products
     * @param $warehouse
     * @return array
     */
    private function getOrderStatus($products, $warehouse){
        $orderStatus = [
            'pass' => true,
            'total_price' => 0,
            'total_count' => 0,
            'products_status' => [],
        ];

        foreach($products as $product ){
            // 获取每个商品的状态
            $status = $this->getProductStatus($product['id'],$product['count'],$warehouse);

            if( !$status['have_stock'] ){
                $orderStatus['pass'] = false;
            }

            $orderStatus['products_status'][] = $status;
            $orderStatus['total_price'] += $status['kind_price'];
            $orderStatus['total_count'] += $status['count'];
        }

        return $orderStatus;
    }

    /**
     * 获取一个商品的库存信息
     * @param $id
     * @param $num
     * @param $warehouse
     * @return array
     * @throws ProductMiss
     */
    private function getProductStatus($id, $num, $warehouse){
        $productStatus = [
            'id' => null,
            'name' => '',
            'count' => 0,
            'price' => 0,
            'have_stock' => true,
            'main_img_url' => '',
        ];
        $index = -1;
        for($i = 0; $i < count($warehouse);$i++){
            if( $warehouse[$i]['id'] == $id ){
                $index = $i;
            }
        }

        if($index == -1){
            throw new ProductMiss('id 为 '.$id.' 的商品不存在');
        }

        $stock = $warehouse[$index];
        $productStatus['id'] = $id;
        $productStatus['name'] = $stock['name'];
        $productStatus['count'] = $num;
        $productStatus['price'] = $stock['price'];
        $productStatus['kind_price'] = $stock['price'] * $num;
        $productStatus['have_stock'] = $stock['stock'] >= $num;
        $productStatus['main_img_url'] = $stock['main_img_url'];

        return $productStatus;
    }

    /**
     * 根据订单获取库存
     * @param $products
     * @return array
     */
    private function getWarehouse($products){
        $ids = [];
        foreach($products as $one ){
            array_push($ids, $one['id']);
        }

        $data = ProductModel::all(function($query) use ($ids){
            $query->where('id','IN',$ids)->field(['id','name','price','stock','main_img_url','from']);
        });

        $warehouse = [];
        foreach ($data as $one){
            $warehouse[] = $one->toArray();
        }

        return $warehouse;
    }
}
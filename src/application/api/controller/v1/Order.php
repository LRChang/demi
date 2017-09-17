<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 01/08/2017
 * Time: 11:29
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\Order as OrderValidate;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderMiss;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkUserToken',
        'checkUserPrimaryScope',
        'checkUserExclusiveScope' => ['only'=> 'placeOrder'],
    ];

    public function placeOrder(){
        $validate = new OrderValidate();
        $validate->scene('buy')->goCheck();

        $data = $validate->getCurrentData();
        $OrderService = new OrderService();
        $order = $OrderService->create($this->uid, $data);

        return $order;
    }

    public function getOne($No = ''){
        $validate = new OrderValidate();
        $validate->scene('getOne')->goCheck();
        $order = OrderModel::getOneByUser($this->uid,$No);
        if( !$order ){
            throw new OrderMiss();
        }

        return $order;
    }

    public function getByPage($status = null, $page = 1, $offset = 20){
        $validate = new OrderValidate();
        $validate->scene('getByPage')->goCheck();
        $data = OrderModel::getByPage($this->uid,$status,$page,$offset);
        return [
            'data' => $data,
            'page' => $page,
        ];
    }
}
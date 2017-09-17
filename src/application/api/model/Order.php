<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 01/08/2017
 * Time: 23:51
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];

    public function getStatusTextAttr($value, $data){
        $status = [1=>'未支付',2=>'已付款',3=>'已发货',4=>'库存不足',5=>'订单完成'];
        return $status[$data['status']];
    }

    /**
     * 根据订单号获取一个用户的订单
     * @param $uid
     * @param $No
     * @return null|static
     */
    public static function getOneByUser($uid,$No){
        return self::get([
            'user_id' => $uid,
            'order_no' => $No,
        ]);
    }

    /**
     * 获取订单分页
     * @param null $uid
     * @param null $status
     * @param int $page
     * @param int $offset
     * @return mixed
     */
    public static function getByPage($uid = null, $status = null, $page = 1, $offset = 20){
        $where = [];
        if($uid){
            $where['user_id'] = $uid;
        }
        if($status){
            $where['status'] = $status;
        }
        return self::all(function($query) use ($where,$page,$offset){
            $query->where($where)->page($page,$offset);
        });
    }

    public function getSnapItemsAttr($value){
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        return json_decode($value);
    }
}
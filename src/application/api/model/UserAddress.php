<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 20:52
 */

namespace app\api\model;


use app\lib\exception\AddressMiss;

class UserAddress extends BaseModel
{
    protected $hidden = ['delete_time','update_time','create_time','user_id'];

    /**
     * 获取用户的一条地址
     * @param int $uid
     * @param int $addressID
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws AddressMiss
     */
    public static function getByUser($uid = 0, $addressID = 0){
        $address = self::where(['user_id' => $uid, 'id' => $addressID])->find();
        if(!$address){
            throw new AddressMiss();
        }

        return $address;
    }

    /**
     * 获取用户所有地址
     * @param int $uid
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAllByUser($uid = 0){
        return self::all( [ 'user_id'=>$uid ] );
    }

    /**
     * 删除用户的一条地址
     * @param int $uid          用户ID
     * @param int $addressID    地址ID
     * @throws AddressMiss
     * @return int
     */
    public static function deleteByUser($uid = 0, $addressID = 0){
        return self::getByUser($uid, $addressID)->delete();
    }

    /**
     * 更新用户的一条地址
     * @param int $uid
     * @param int $addressID
     * @param $data
     * @return false|int
     * @throws AddressMiss
     */
    public static function updateByUser($uid = 0, $addressID = 0, $data){
        return self::getByUser($uid, $addressID)->save($data);
    }

    /**
     * 将用户的一条地址设置为默认地址，其余地址取消默认
     * @param int $uid
     * @param int $addressID
     * @return array|false
     * @throws AddressMiss
     */
    public static function setDefault($uid = 0 , $addressID = 0){
        $all = self::getAllByUser($uid);
        $isOwner = false;
        $update = [];

        foreach($all as $one){
            if( $one['id'] == $addressID ){

                $isOwner = true;
                if( !$one['is_default'] ){
                    $update[] = [ 'id'=>$one['id'], 'is_default'=>1 ];
                }

            }elseif( $one['is_default'] ){
                $update[] = [ 'id'=>$one['id'], 'is_default'=>null ];
            }
        }

        if( !$isOwner ){
            throw new AddressMiss();
        }

        if( empty($update) ){
            throw new AddressMiss([
                'httpCode' => 403,
                'msg' => '已经是默认地址',
                'errorCode' => 70003,
            ]);
        }

        return $all[0]->saveAll($update);
    }
}
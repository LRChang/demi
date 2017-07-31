<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 13:06
 */

namespace app\api\model;


class User extends BaseModel
{
    /**
     * 根据微信 openid 获取用户
     * @param string $openid
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function getByOpenID($openid = ''){
        return self::where('openid','=', $openid)->find();
    }

    /**
     * 根据微信 openid 创建一个新用户
     * @param string $openid
     * @return $this
     */
    public static function createByOpenID($openid = ''){
        return self::create([
            'openid' => $openid
        ]);
    }

    public function address(){
        return $this->hasMany('UserAddress','user_id','id');
    }
}
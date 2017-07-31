<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 17:14
 */

namespace app\api\service;


use app\lib\exception\TokenError;
use think\Cache;
use think\Config;
use think\Exception;
use think\Request;

class Token
{
    /**
     * 生成 token
     * @return string
     */
    public static function generateToken(){
        $randChars = getRandChars(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = Config::get('secure.token_salt');

        return md5( $randChars.$timestamp.$salt );
    }

    /**
     * 保存缓存并返回token
     * @param $value
     * @return string
     * @throws Exception
     */
    public static function saveToCache($value){
        $expire = Config::get('setting.token_expire_id');
        $token = self::generateToken();

        if( !Cache::set($token, $value, $expire) ){
            throw new Exception('服务器缓存错误');
        }

        return $token;
    }

    /**
     * 获取token变量的值
     * @param null $key
     * @return mixed
     * @throws Exception
     * @throws TokenError
     */
    public static function getCurrentTokenVar($key = null){
        $token = Request::instance()->header('token');
        $values = Cache::get($token);

        if( !is_array($values) ){
            $values = json_decode($values, true);
        }

        if(!$values){
            throw new TokenError();
        }

        if( empty($key) ){
            return $values;
        }

        if( !array_key_exists($key, $values) ){
            throw new Exception('所尝试获取的 token 变量并不存在');
        }

        return $values[$key];
    }

    /**
     * 获取当前用户ID
     * @return mixed
     */
    public static function getCurrentUID(){
        return self::getCurrentTokenVar('uid');
    }
}
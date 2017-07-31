<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 13:03
 */

namespace app\api\service;


use app\api\model\User as UserModel;
use app\lib\exception\WeChatError;
use think\Cache;
use think\Config;
use think\Exception;

class MiniappToken extends Token
{
    protected $code; // wx.login()返回的code码
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginURL;

    public function __construct($code = ''){
        $this->code = $code;
        $this->wxAppID = Config::get('wx.app_id');
        $this->wxAppSecret = Config::get('wx.app_secret');
        $this->wxLoginURL = sprintf(Config::get('wx.login_url'),
            $this->wxAppID,$this->wxAppSecret,$this->code);
    }

    /**
     * 获取 token
     * @return string
     * @throws Exception
     */
    public function get(){
        $result = curl_get($this->wxLoginURL);
        $wxResult = json_decode($result, true);
        if(!$wxResult){
            throw new Exception('获取 openid 和 session_key 时异常，微信内部错误');
        }

        if( array_key_exists('errcode',$wxResult) ){
            $this->returnLoginFail($wxResult);
        }

        return $this->grantToken($wxResult);
    }

    /**
     * 给用户颁发令牌
     * @param $wxResult
     * @return string
     */
    private function grantToken($wxResult){
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);

        if(!$user){
            $user = UserModel::createByOpenID($openid);
        }

        $value = $this->prepareCacheValue($wxResult,$user->id);
        $token = self::saveToCache($value);
        return $token;
    }

    /**
     * 准备缓存的用户数据
     * @param $wxResult
     * @param $uid
     * @return mixed
     */
    private function prepareCacheValue($wxResult, $uid){
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        $cacheValue['scope'] = 16;

        return $cacheValue;
    }

    /**
     * 处理微信获取 openid 失败
     * @param $wxResult
     * @throws WeChatError
     */
    private function returnLoginFail($wxResult){
        throw new WeChatError([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode'],
        ]);
    }
}
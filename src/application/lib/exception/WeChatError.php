<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 15:24
 */

namespace app\lib\exception;


class WeChatError extends BaseException
{

    // HTTP 状态吗
    public $httpCode = 400;

    // 异常信息
    public $msg = '微信服务器接口调用失败';

    // 自定义错误码
    public $errorCode = 9999;
}
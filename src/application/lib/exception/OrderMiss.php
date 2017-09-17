<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 02/08/2017
 * Time: 00:54
 */

namespace app\lib\exception;


class OrderMiss extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 404;

    // 异常信息
    public $msg = "订单不存在";

    // 自定义错误码
    public $errorCode = 80001;
}
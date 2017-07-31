<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 30/07/2017
 * Time: 12:20
 */

namespace app\lib\exception;


class AddressMiss extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 404;

    // 异常信息
    public $msg = "该地址不存在";

    // 自定义错误码
    public $errorCode = 70001;
}
<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 30/07/2017
 * Time: 00:52
 */

namespace app\lib\exception;


class UserMiss extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 404;

    // 异常信息
    public $msg = "用户不存在";

    // 自定义错误码
    public $errorCode = 60001;
}
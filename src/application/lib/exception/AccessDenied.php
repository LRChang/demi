<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 31/07/2017
 * Time: 21:00
 */

namespace app\lib\exception;


class AccessDenied extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 403;

    // 异常信息
    public $msg = "无权限操作";

    // 自定义错误码
    public $errorCode = 10001;
}
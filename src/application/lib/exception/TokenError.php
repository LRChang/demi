<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 17:49
 */

namespace app\lib\exception;


class TokenError extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 401;

    // 异常信息
    public $msg = "token 已过期或无效";

    // 自定义错误码
    public $errorCode = 10000;
}
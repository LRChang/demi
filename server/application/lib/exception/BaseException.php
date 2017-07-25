<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 20/07/2017
 * Time: 17:42
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    // HTTP 状态吗
    public $httpCode = 400;

    // 异常信息
    public $msg = "参数错误";

    // 自定义错误码
    public $errorCode = 10000;
}
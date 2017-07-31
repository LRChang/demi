<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 25/07/2017
 * Time: 13:13
 */

namespace app\lib\exception;


class ParamError extends BaseException
{
    public $httpCode = 400;
    public $msg = '输入参数错误';
    public $errorCode = 10000;
}
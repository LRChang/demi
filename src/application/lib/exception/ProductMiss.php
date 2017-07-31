<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 11:54
 */

namespace app\lib\exception;


class ProductMiss extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 404;

    // 异常信息
    public $msg = "所查找的商品不存在";

    // 自定义错误码
    public $errorCode = 20001;
}
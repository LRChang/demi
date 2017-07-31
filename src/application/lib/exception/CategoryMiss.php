<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 13:02
 */

namespace app\lib\exception;


class CategoryMiss extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 404;

    // 异常信息
    public $msg = "指定的 category 不存在";

    // 自定义错误码
    public $errorCode = 50001;
}
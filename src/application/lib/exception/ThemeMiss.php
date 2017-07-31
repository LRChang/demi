<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 14:08
 */

namespace app\lib\exception;


class ThemeMiss extends BaseException
{
    public $httpCode = 404;
    public $msg = '所请求的Theme不存在';

    // 错误码
    public $errorCode = 30001;
}
<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 22/07/2017
 * Time: 17:18
 */

namespace app\lib\exception;


class BannerMiss extends BaseException
{
    public $httpCode = 404;
    public $msg = '所请求的Banner不存在';

    // 错误码
    public $errorCode = 40001;
}
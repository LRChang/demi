<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 05/08/2017
 * Time: 14:13
 */

namespace app\lib\exception;


class UploadFail extends BaseException
{
    // HTTP 状态吗
    public $httpCode = 400;

    // 异常信息
    public $msg = "上传出错";

    // 自定义错误码
    public $errorCode = 10003;
}
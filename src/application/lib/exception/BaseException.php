<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 20/07/2017
 * Time: 17:42
 */

namespace app\lib\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    // HTTP 状态吗
    public $httpCode = 400;

    // 异常信息
    public $msg = "参数错误";

    // 自定义错误码
    public $errorCode = 10000;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        //parent::__construct($message, $code, $previous);

        if( empty($message) ){
            return;
        }

        if( is_string($message) ){
            $this->msg = $message;
            return;
        }

        if( is_array($message) ){
            if( array_key_exists('httpCode', $message) ){
                $this->httpCode = $message['httpCode'];
            }
            if( array_key_exists('msg', $message) ){
                $this->msg = $message['msg'];
            }
            if( array_key_exists('errorCode', $message) ){
                $this->errorCode = $message['errorCode'];
            }
            return;
        }
    }
}
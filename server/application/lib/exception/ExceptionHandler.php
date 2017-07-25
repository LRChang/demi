<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 20/07/2017
 * Time: 17:43
 */

namespace app\lib\exception;


use think\Config;
use think\Exception;
use think\exception\Handle;
use app\lib\exception\BaseException;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $httpCode;
    private $msg;
    private $errorCode;

    public function render(\Exception $e){

        if( $e instanceof BaseException){
            // 如果是自定义的异常
            $this->httpCode = $e->httpCode;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;

        }else{
            $this->httpCode = 500;
            $this->msg = '服务器内部错误～';
            $this->errorCode = 9999;

            // 记录日志
            $this->recordError($e);
        }

        $request = Request::instance();

        $result = [
            'error_code' => $this->errorCode,
            'msg' => $this->msg,
            'request_url' => $request->url()
        ];

        return json($result, $this->httpCode);
    }

    private function recordError(\Exception $e){
        Log::init( Config::get('log') );
        Log::record($e->getMessage());
    }
}
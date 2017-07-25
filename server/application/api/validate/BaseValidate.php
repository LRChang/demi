<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 19/07/2017
 * Time: 19:15
 */

namespace app\api\validate;


use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 获取https参数，验证参数
     */
    public function goCheck(){
        $request = Request::instance();
        $params = $request->param();

        if( !$this->check($params) ){
            $error = $this->error;
            throw new Exception($error);
        }else{
            return true;
        }
    }
}
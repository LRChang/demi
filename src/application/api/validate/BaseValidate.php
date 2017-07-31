<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 19/07/2017
 * Time: 19:15
 */

namespace app\api\validate;


use app\lib\exception\ParamError;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    protected $requestData = null; // 请求参数

    public function __construct(array $rules = [], array $message = [], array $field = [])
    {
        parent::__construct($rules, $message, $field);

        // 保存请求值
        $this->requestData = Request::instance()->param();
    }

    /**
     * 获取https参数，验证参数
     */
    public function goCheck(){
        $params = $this->requestData;

        if( !$this->batch()->check($params) ){
            throw new ParamError([
                'msg' => $this->error
            ]);
        }else{
            return true;
        }
    }

    /**
     * 获取当前合法参数
     * @return array
     */
    public function getCurrentData(){
        $data = [];

        $scene = $this->currentScene;
        if( !$scene ){
            foreach($this->rule as $key => $value){
                $data[$key] = $this->requestData[$key];
            }

            return $data;
        }

        foreach($this->scene[$scene] as $key => $value){
            if( is_numeric($key) ){
                $data[$value] = $this->requestData[$value];
            }else{
                $data[$key] = $this->requestData[$key];
            }
        }

        return $data;
    }

    /**
     * 验证必须是正整数
     * @param $value
     * @return bool
     */
    protected function isPositiveInt($value){
        if (is_numeric($value) && is_int($value + 0 ) && ($value + 0) > 0){
            return true;
        }

        return false;
    }

    /**
     * 验证值为一组","连接的正整数
     * @param $value
     * @return bool
     */
    protected function checkIDs($value){
        $ids = explode(',',$value);
        if( empty($ids) ){
            return false;
        }

        foreach ($ids as $id){
            if( !$this->isPositiveInt($id) ){
                return false;
            }
        }

        return true;
    }

    /**
     * 验证值不能为空
     * @param $value
     * @return bool
     */
    protected function isNotEmpty($value){
        return !empty($value);
    }

    /**
     * 验证手机号
     * @param $value
     * @return bool
     */
    protected function isMobile($value){
        $rule = '^1(3|4|5|7|8)\d{9}$^';
        return preg_match($rule, $value) ? true : false;
    }
}
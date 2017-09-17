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
    protected $tempData = null; // 传入的验证数据
    protected $isRequest = true; // 是否为验证请求参数

    public function __construct(array $rules = [], array $message = [], array $field = [])
    {
        parent::__construct($rules, $message, $field);

        // 保存请求值
        $this->requestData = Request::instance()->param();
        $this->isRequest = true;
    }

    /**
     * 批量验证参数
     * @param null $params
     * @return bool
     * @throws ParamError
     */
    public function goCheck($params = null){
        // 未传值，就验证请求参数
        if( empty($params) ){
            $params = $this->requestData;
        }else{
            // 保存传入的数据
            $this->tempData = $params;
            $this->isRequest = false;
        }

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
        $pool = $this->isRequest ? $this->requestData : $this->tempData;
        $data = [];

        $scene = $this->currentScene;
        if( !$scene ){
            foreach($this->rule as $key => $value){
                $data[$key] = $pool[$key];
            }

            return $data;
        }

        foreach($this->scene[$scene] as $key => $value){
            if( is_numeric($key) ){
                $data[$value] = $pool[$value];
            }else{
                $data[$key] = $pool[$key];
            }
        }

        return $data;
    }

    /**
     * 替换数据
     * @param $field
     * @param $data
     */
    protected function replaceData($field, $data){
        if( $this->isRequest ){
            $this->requestData[$field] = $data;
        }else{
            $this->tempData[$field] = $data;
        }
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
     * 验证一个数组中的值是否都是正整数
     * @param $value
     * @return bool
     */
    protected function checkArrayIDs($value){
        if( empty($value) || !is_array($value)){
            return false;
        }

        foreach($value as $one){
            if( !$this->isPositiveInt($one) ){
                return false;
            }
        }

        return true;
    }

    /**
     * 验证数组是每一个元素都是非空字符串
     * @param $value
     * @return bool
     */
    protected function checkArrayString($value){
        // 一定是非空数组
        if( !is_array($value) || empty($value)  ){
            return false;
        }

        // 非空字符串
        foreach($value as $one){
            if( ( !is_string($one) && !is_numeric($one) ) || $one === '' ){
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

    /**
     * 去除数组中空元素
     * @param $value
     * @param $rule
     * @param $data
     * @param $field
     * @param $title
     * @return bool
     */
    protected function dropArrayEmptyElement($value, $rule, $data, $field, $title){
        if(!is_array($value)){
            return false;
        }

        $result = [];
        foreach ($value as $key => $v){
            if( !empty($v) ){
                $result[$key] = $v;
            }
        }

        $this->replaceData($field, $result);
        return true;
    }
}
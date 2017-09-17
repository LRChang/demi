<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 11:00
 */

namespace app\api\validate;


class Product extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInt',
        'offset' => 'isPositiveInt|elt:50',
        'cid' => 'require|isPositiveInt', // 产品分类id
        'id' => 'require|isPositiveInt', // 产品id
        'count' => 'require|isPositiveInt', // 产品数量

        'main_img' => 'require|isPositiveInt', // 主图id
        'name' => 'require|isNotEmpty', // 商品名称
        'category_id' => 'require|isPositiveInt', // 商品分类
        'price' => 'require', // 商品价格
        'property_name' => 'require|dropArrayEmptyElement', // 属性名称
        'property_detail' => 'require|dropArrayEmptyElement|checkProperties', // 属性
        'stock' => 'require|egt:0', // 库存
        'detail_img' => 'require|checkArrayIDs', // 详情图ID
    ];

    protected $message = [
        'page' => 'page 必须是正整数',
        'offset.isPositiveInt' => 'offset 必须是正整数',
        'offset.elt' => 'offset 超出最大值',
        'id.isPositiveInt' => 'id 必须是正整数',
        'num.isPositiveInt' => '数量 必须是正整数',
        'property_name.checkProperties' => '属性与属性名不能为空，且一一对应',
        'property_detail.checkProperties' => '属性与属性名不能为空，且一一对应',
    ];

    protected $scene = [
        'recent' => ['page','offset'],
        'category' => ['page','offset','cid'],
        'buy' => ['id','count'],
        'detail' => ['id'],
        'create' => ['main_img','category_id','name','price','stock','property_name','property_detail','detail_img'],
        'update' => ['id','main_img','category_id','name','price','stock','property_name','property_detail','detail_img'],
    ];

    // 检查属性
    protected function checkProperties($value, $rule, $data, $field, $title){
        // 检查每一项都是非空字符串
        if( !$this->checkArrayString($this->requestData['property_detail']) ){
            return false;
        }

        // 检查每一项都是非空字符串
        if( !$this->checkArrayString($this->requestData['property_name']) ){
            return false;
        }

        // 属性名个数与属性个数匹配
        if( count($this->requestData['property_detail']) != count($this->requestData['property_name']) ){
            return false;
        }

        // 检查键，必须为整数
        foreach ($this->requestData['property_name'] as $key => $v){
            if( !is_int($key) ){
                return false;
            }
            // 键名必须有对应的键值
            if( !isset($this->requestData['property_detail'][$key]) ){
                return false;
            }
        }

        // 检查键，必须为整数
        foreach ($this->requestData['property_detail'] as $key => $v){
            if( !is_int($key) ){
                return false;
            }
            // 键名必须有对应的键值
            if( !isset($this->requestData['property_name'][$key]) ){
                return false;
            }
        }

        return true;
    }
}
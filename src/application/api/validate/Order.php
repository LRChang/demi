<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 01/08/2017
 * Time: 11:31
 */

namespace app\api\validate;


class Order extends BaseValidate
{
    protected $rule = [
        'address' => 'require|array|isNotEmpty|checkAddress',
        'products' => 'require|array|isNotEmpty|checkProducts',
        'No' => 'require|isNotEmpty|alphaNum',
        'status' => 'isPositiveInt|between:1,5',
        'page' => 'isPositiveInt',
        'offset' => 'isPositiveInt|elt:50',
    ];

    protected $message = [
        'products.checkProducts' => '商品不能重复',
        'No.alphaNum' => '订单号仅由字母数字组成',
//        'No.length' => '订单号长度错误',
    ];

    protected $scene = [
        'buy' => ['address','products'],
        'getOne' => ['No'],
        'getByPage' => ['status','page','offset'],
    ];

    /**
     * 验证地址参数
     * @param $value
     * @return bool
     */
    protected function checkAddress($value){
        $validate = new UserAddress();
        $validate->scene('buy');
        return $validate->goCheck($value);
    }

    /**
     * 验证商品数组参数
     * @param $value
     * @return bool
     */
    protected function checkProducts($value, $rule, $data, $field, $title){
        $flag = [];
        $products = [];
        foreach($value as $product){
            // 验证参数是否符合规则
            $validate = new Product();
            $validate->scene('buy')->goCheck($product);
            // 获取过滤过的数据
            $products[] = $validate->getCurrentData();

            // 商品不能重复
            $id = $product['id'];
            if( isset( $flag[$id] ) ){
                return false;
            }

            $flag[$id] = true;
        }

        $this->replaceData($field,$products);
        return !empty($flag);
    }
}
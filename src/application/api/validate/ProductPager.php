<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 11:00
 */

namespace app\api\validate;


class ProductPager extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInt',
        'offset' => 'isPositiveInt|elt:50',
        'cid' => 'require|isPositiveInt', // 产品分类id
    ];

    protected $message = [
        'page' => 'page 必须是正整数',
        'offset.isPositiveInt' => 'offset 必须是正整数',
        'offset.elt' => 'offset 超出最大值'
    ];

    protected $scene = [
        'recent' => ['page','offset'],
        'category' => ['page','offset','cid']
    ];
}
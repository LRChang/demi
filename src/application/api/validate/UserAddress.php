<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 20:33
 */

namespace app\api\validate;


class UserAddress extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInt',
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'district' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty',
    ];

    protected $message = [
        'id.isPositiveInt' => 'id 必须为正整数',
        'name.isNotEmpty' => 'name 不允许为空',
        'mobile.isMobile' => 'mobile 不合法',
        'province.isNotEmpty' => 'province 不允许为空',
        'city.isNotEmpty' => 'city 不允许为空',
        'district.isNotEmpty' => 'district 不允许为空',
        'detail.isNotEmpty' => 'detail 不允许为空',
    ];

    protected $scene = [
        'create' => ['name','mobile','province','city','district','detail'],
        'edit' => ['id','name','mobile','province','city','district','detail'],
        'getAll' => [],
        'setDefault' => ['id'],
        'delete' => ['id'],
    ];
}
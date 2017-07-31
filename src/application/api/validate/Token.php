<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 12:41
 */

namespace app\api\validate;


class Token extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty',
    ];

    protected $message = [
        'code.require' => 'code 必须',
        'code.isNotEmpty' => 'code 不能为空',
    ];

    protected $scene = [
        'miniapp' => ['code'],
    ];
}
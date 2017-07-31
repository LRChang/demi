<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 19/07/2017
 * Time: 19:23
 */

namespace app\api\validate;

use app\api\validate\BaseValidate;
use think\Exception;

class IDPostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInt'
    ];

    protected $message = [
        'id.require' => 'id 参数必须',
        'id.isPositiveInt' => 'id 必须是正整数'
    ];
}
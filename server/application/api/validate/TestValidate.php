<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 19/07/2017
 * Time: 17:07
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate
{
    protected $rule =[
            'name' => 'require|max:10',
            'id' => 'integer|max:12'
        ];
}
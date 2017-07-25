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

    /**
     * 验证必须是正整数
     * @param $value
     * @param $rule
     * @param $data
     * @param $field
     * @param $title
     * @return bool|string
     */
    protected function isPositiveInt($value, $rule, $data, $field, $title){
        if (is_numeric($value) && is_int($value + 0 ) && ($value + 0) > 0){
            return true;
        }

        return $field . '必须是正整数';
    }
}
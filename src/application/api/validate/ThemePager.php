<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 17:41
 */

namespace app\api\validate;


class ThemePager extends BaseValidate
{
    protected $rule = [
        'id' => 'require|checkIDs',
        'page' => 'isPositiveInt',
        'offset' => 'isPositiveInt|elt:50'
    ];

    protected $message = [
        'id.checkIDs' => 'ids 必须是以","分隔的正整数',
        'page.isPositiveInt' => 'page 必须是正整数',
        'offset.isPositiveInt' => 'offset 必须是正整数',
        'offset.elt' => 'offset 超出最大值',
    ];
}
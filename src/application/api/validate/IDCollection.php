<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 14:34
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids.checkIDs' => 'ids 必须是以","分隔的正整数'
    ];
}
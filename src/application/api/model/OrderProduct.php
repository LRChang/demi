<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 02/08/2017
 * Time: 00:16
 */

namespace app\api\model;


class OrderProduct extends BaseModel
{
    protected $hidden = ['delete_time','create_time','update_time'];
}
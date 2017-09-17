<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 07/08/2017
 * Time: 21:49
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['create_time','delete_time','update_time','product_id','pivot'];
}
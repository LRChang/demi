<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 07/08/2017
 * Time: 19:59
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['create_time','delete_time','update_time','id','pivot'];

    public function img(){
        return $this->hasOne('Image','id','img_id');
    }
}
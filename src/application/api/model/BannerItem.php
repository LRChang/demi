<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 11:37
 */

namespace app\api\model;


use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['id','banner_id','img_id','delete_time','update_time'];

    public function img(){
        return $this->hasOne('Image','id','img_id');
    }
}
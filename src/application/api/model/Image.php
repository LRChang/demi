<?php

namespace app\api\model;

use think\Config;
use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['id','delete_time','update_time','create_time'];

    public function getUrlAttr($value, $data){
        return $this->prefixImgUrl($value, $data);
    }
}

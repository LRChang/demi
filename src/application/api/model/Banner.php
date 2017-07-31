<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 22/07/2017
 * Time: 17:00
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends BaseModel
{
    protected $hidden = ['id','delete_time','update_time'];

    public static function getBannerByID($id){
        return self::with(['items.img'])->find($id);
    }

    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 16:19
 */

namespace app\api\model;


use think\Model;

class Product extends BaseModel
{
    protected $hidden = ['delete_time','update_time','category_id','create_time','img_id','from', 'pivot'];

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    /**
     * 获取最近新品
     * @param int $page
     * @param int $offset
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getMostRecent($page = 1, $offset = 20){
        return self::page($page, $offset)
            ->order('create_time desc')
            ->select();
    }
}
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
    protected $hidden = ['delete_time','update_time','create_time','from', 'pivot'];

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

    /**
     * 获取商品详情
     * @param int $id
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getDetail($id = 0){
        return self::with(['detailImgs'=> ['img'],'properties'])
            ->where('id','=',$id)
            ->find();
    }

    // 商品详情图
    public function detailImgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    // 商品属性
    public function properties(){
        return $this->hasmany('ProductProperty','product_id','id');
    }
}
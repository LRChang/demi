<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 12:30
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id'];

    private static $productsPage = 1;
    private static $productsOffset = 20;

    /**
     * 获取所有分类
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAll(){
        return self::with('img')->select();
    }

    /**
     * 获取一个分类及其下商品
     * @param int $id       分类ID
     * @param int $page     页码
     * @param int $offset   每页数量
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function getProductsByCate($id = 0, $page = 1, $offset = 20){
        self::$productsPage = $page;
        self::$productsOffset = $offset;

        return self::with(['img','products'])->where('id','=',$id)->find();
    }

    public function img(){
        return $this->hasOne('Image','id','topic_img_id');
    }

    public function products(){
        return $this->hasMany('Product','category_id','id')
            ->page(self::$productsPage, self::$productsOffset);
    }
}
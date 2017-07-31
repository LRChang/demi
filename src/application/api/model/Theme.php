<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 13:55
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['id','delete_time','update_time','head_img_id','topic_img_id'];

    private static $productsPage = 1;   // 页码
    private static $productsOffset = 3; // 每页数量

    /**
     * 获取主题及其下商品
     * @param int $id       主题ID
     * @param int $page     页码
     * @param int $offset   每页数量
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function getCompleteTheme($id = 0, $page = 1, $offset = 10){
        self::$productsPage = $page;
        self::$productsOffset = $offset;
        return self::with(['topicImg','headImg','products'])->find($id);
    }

    /**
     * 根据 ids 获取多个主题
     * @param $ids ID 字符串 '1,2,3'
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getThemesByIDs($ids){
        return self::with(['topicImg','headImg'])
            ->where('id','IN',$ids)
            ->select();
    }

    public function topicImg(){
        return $this->hasOne('Image','id','topic_img_id');
    }

    public function headImg(){
        return $this->hasOne('Image','id','head_img_id');
    }

    public function products(){
        $page = self::$productsPage;
        $offset = self::$productsOffset;
        return $this->belongsToMany('Product','theme_product','product_id','theme_id')
            ->page($page,$offset);
    }
}
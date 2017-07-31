<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 13:31
 */

namespace app\api\model;


use think\Config;
use think\Model;
use traits\model\SoftDelete;

class BaseModel extends Model
{
    use SoftDelete; // 软删除
    protected $deleteTime = 'delete_time';

    /**
     * 添加图片地址前缀
     * @param $value
     * @param $data
     * @return string
     */
    protected function prefixImgUrl($value, $data){
        if($data['from'] == 1){
            // 服务器本地图片
            return Config::get('setting.img_prefix') . $value;
        }

        // 云存储图片
        return $value;
    }
}
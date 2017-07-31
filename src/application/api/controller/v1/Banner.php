<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 19/07/2017
 * Time: 13:08
 */

namespace app\api\controller\v1;


use app\api\validate\IDPostiveInt;
use app\api\validate\TestValidate;
use app\lib\exception\BannerMiss;
use think\Validate;
use app\api\model\Banner as BannerModel;

class Banner
{
    /**
     * @URL /banner/:id
     */
    public function getBanner($id = 0){

        // 参数验证
        (new IDPostiveInt())->goCheck();

        // 获取数据
        $banner = BannerModel::getBannerByID($id);
        if(!$banner){
            throw new BannerMiss('所请求的banner不存在');
        }

        return json($banner);
    }
}
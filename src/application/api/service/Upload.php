<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 05/08/2017
 * Time: 13:54
 */

namespace app\api\service;


use app\lib\exception\UploadFail;

class Upload
{
    // 上传多张图片
    public static function handleImgUpload($key = ''){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($key);
        if(!$file){
            throw new UploadFail(['msg'=>'文件不存在']);
        }

        if(is_array($file)){
            $file = $file[0];
        }

        // 移动到框架应用根目录/public/images 限制2M大小
        $info = $file->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'images');

        if(!$info){
            throw new UploadFail([
                'msg' => $file->getError()
            ]);
        }

        return $info->getSaveName();
    }
}
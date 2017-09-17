<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 05/08/2017
 * Time: 13:52
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\Image as ImageModel;
use app\api\service\Upload as UploadService;

class Upload extends BaseController
{
    protected $beforeActionList = [
        'checkUserPrimaryScope'
    ];

    public function img(){
        $url = UploadService::handleImgUpload('image');
        $data = [
            'from' => 1,
            'url' => '/'.$url
        ];

        return ImageModel::create($data)->visible(['id','url','create_time']);
    }
}
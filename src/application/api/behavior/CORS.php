<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 04/08/2017
 * Time: 14:37
 */

namespace app\api\behavior;


class CORS
{
    public function appInit(&$params){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: token,Origin,X-Requested-With,Content-Type,Accept');
        header('Access-Control-Allow-Methods: POST,GET');

        if(request()->isOptions()){
            exit();
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 13:40
 */

namespace app\api\controller\v2;


class Banner
{
    public function getBanner($id){
        return 'this is version 2 , id = ' . $id;
    }
}
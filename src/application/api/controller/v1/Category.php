<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 12:30
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryMiss;

class Category
{
    /**
     * @URL /category/all
     */
    public function getAll(){
        $categories = CategoryModel::getAll();
        if( !$categories ){
            throw new CategoryMiss();
        }

        return $categories;
    }
}
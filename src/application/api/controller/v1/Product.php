<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 11:36
 */

namespace app\api\controller\v1;


use app\api\validate\ProductPager;
use app\api\model\Product as ProductModel;
use app\lib\exception\CategoryMiss;
use app\lib\exception\ProductMiss;
use app\api\model\Category as CategoryModel;

class Product
{
    /**
     * @URL /product/recent?page=1&offset=20
     */
    public function getRecent($page = 1, $offset = 20){
        (new ProductPager())->scene('category')->goCheck();

        $products = ProductModel::getMostRecent($page, $offset);
        if(!$products){
            throw new ProductMiss();
        }

        return $products;
    }

    /**
     * @URL /product/cate/:cid?page=1&offset=20
     */
    public function getCategoryItems($cid = 0, $page = 1, $offset = 20){
        (new ProductPager())->scene('category')->goCheck();

        $category = CategoryModel::getProductsByCate($cid,$page,$offset);

        if( !$category ){
            throw new CategoryMiss();
        }

        return $category;
    }
}
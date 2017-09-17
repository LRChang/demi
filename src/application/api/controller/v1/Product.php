<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 28/07/2017
 * Time: 11:36
 */

namespace app\api\controller\v1;


use app\api\validate\Product as ProductValidate;
use app\api\model\Product as ProductModel;
use app\lib\exception\CategoryMiss;
use app\lib\exception\ProductMiss;
use app\api\model\Category as CategoryModel;
use app\api\service\Product as ProductService;

class Product
{
    /**
     * @URL /product/recent?page=1&offset=20
     */
    public function getRecent($page = 1, $offset = 20){
        (new ProductValidate())->scene('category')->goCheck();

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
        (new ProductValidate())->scene('category')->goCheck();

        $category = CategoryModel::getProductsByCate($cid,$page,$offset);

        if( !$category ){
            throw new CategoryMiss();
        }

        return $category;
    }

    public function getProductDetail($id = null){
        (new ProductValidate())->scene('detail')->goCheck();

        $product = ProductModel::getDetail($id);
        if(!$product){
            throw new ProductMiss();
        }

        return $product;
    }

    // 添加商品
    public function createProduct(){
        $validate = new ProductValidate();
        $validate->scene('create')->goCheck();

        // 获取过滤后的参数
        $params = $validate->getCurrentData();

        $service = new ProductService();
        $result = $service->createOrUpdate($params);
        return $result;
    }

    // 更新商品
    public function updateProduct(){
        $validate = new ProductValidate();
        $validate->scene('update')->goCheck();

        // 获取过滤后的参数
        $params = $validate->getCurrentData();

        $service = new ProductService();
        $result = $service->createOrUpdate($params);
        return $result;
    }
}
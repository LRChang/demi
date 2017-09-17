<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 07/08/2017
 * Time: 17:25
 */

namespace app\api\service;

use app\api\model\Image;
use app\api\model\Product as ProductModel;
use app\api\model\Image as ImageModel;
use app\api\model\ProductImage;
use app\api\model\ProductProperty;
use app\lib\exception\ProductMiss;
use think\Exception;

class Product extends BaseService
{
    private $mainImg = null; // 商品主图
    private $detailImg = null; // 详情图

    /**
     * @param $params
     * @return \app\api\model\Product
     */
    public function createOrUpdate($params){

        // 检查图片
        $this->checkMainImg($params['main_img']);
        $this->checkDetailImg($params['detail_img']);

        // 保存商品记录
        $productData = $this->prepareProductData($params);
        if ( isset($params['id']) ){
            // 更新
            $product = new ProductModel();
            $product->isUpdate(true)->save($productData);
        }else{
            // 新增
            $product = ProductModel::create($productData);
        }

        // 保存商品详情图
        $this->saveDetailImgs($product->id);

        // 保存属性
        $this->saveProperties($params['property_name'], $params['property_detail'], $product->id);

        return $product;
    }



    /**
     * 保存商品属性
     * @param $propertiesName
     * @param $propertiesDetail
     * @param $productID
     */
    private function saveProperties($propertiesName,$propertiesDetail,$productID){
        // 获取新旧记录
        $newProperties = $this->preparePropertiesData($propertiesName,$propertiesDetail,$productID);
        $originProperties = ProductProperty::all(['product_id' => $productID ]);

        // 对比记录差异
        $data = $this->differRecords($newProperties, $originProperties, 'id', [], ['id']);

        // 保存记录变化
        if( !empty($data['create']) ){
            $properties = new ProductProperty();
            $properties->saveAll($data['create']);
        }

        if( !empty($data['update']) ){
            $properties = new ProductProperty();
            $properties->saveAll($data['update']);
        }

        if( !empty($data['delete']) ){
            $ids = [];
            foreach ($data['delete'] as $item ){
                $ids[] = $item['id'];
            }
            ProductProperty::destroy($ids);
        }
    }

    /**
     * 准备属性数据
     * @param $propertiesName
     * @param $propertiesDetail
     * @param $productID
     * @return array
     */
    private function preparePropertiesData($propertiesName,$propertiesDetail,$productID){
        $data = [];
        foreach ($propertiesName as $key => $name){
            $temp = [
                'id' => $key,
                'name' => $name,
                'detail' => $propertiesDetail[$key],
                'product_id' => $productID,
            ];
            $data[] = $temp;
        }

        return $data;
    }

    /**
     * 保存商品详情图
     * @param $productID
     * @throws Exception
     */
    private function saveDetailImgs($productID){
        if ( !$productID ){
            throw new Exception(['msg' => '更新产品图时，产品ID不能为空']);
        }

        // 获取新旧记录
        $newDetailImgs = $this->prepareDetailImgsData($productID);
        $originDetailImgs = ProductImage::all(['product_id' => $productID ]);

        // 对比记录差异
        $data = $this->differRecords($newDetailImgs, $originDetailImgs, 'img_id', ['id']);

        // 保存记录变化
        if ( !empty($data['create']) ){
            $productImage = new ProductImage();
            $productImage->saveAll($data['create']);
        }

        if ( !empty($data['update']) ){
            $productImage = new ProductImage();
            $productImage->saveAll($data['update']);
        }

        if ( !empty($data['delete']) ){
            $ids = [];
            foreach ($data['delete'] as $item ){
                $ids[] = $item['id'];
            }

            ProductImage::destroy($ids);
        }
    }

    /**
     * 准备详情图数据
     * @param $productID
     * @return array
     */
    private function prepareDetailImgsData($productID){
        $data = [];
        $order = 1;
        foreach($this->detailImg as $img){
            $temp = [
                'img_id' => $img->getData('id'),
                'order' => $order,
                'product_id' => $productID,
            ];

            $data[] = $temp;
            $order++;
        }

        return $data;
    }

    /**
     * 准备商品数据
     * @param $params
     * @return array
     */
    private function prepareProductData($params){
        $data = [
            'name' => $params['name'],
            'price' => $params['price'],
            'stock' => $params['stock'],
            'category_id' => $params['category_id'],
            'img_id' => $this->mainImg->getData('id'),
            'main_img_url' => $this->mainImg->getData('url'),
            'from' => $this->mainImg->getData('from'),
        ];

        if( isset($params['id']) ){
            // 修改商品时加上商品ID
            $data['id'] = $params['id'];
        }

        return $data;
    }

    /**
     * 检查商品主图
     * @param $id
     */
    private function checkMainImg($id){
        $this->mainImg = $this->getImgs($id);
    }

    /**
     * 检查商品详情图
     * @param $ids
     * @throws ProductMiss
     */
    private function  checkDetailImg($ids){
        $imgs = $this->getImgs($ids);

        $data = [];
        //  按照$ids 的顺序排序
        foreach($ids as $id){
            foreach($imgs as $img){
                if($img->id == $id){
                    $data[] = $img;
                    continue;
                }
            }
        }

        if( count($data) != count($ids) ){
            // 部分图片不存在
            throw new ProductMiss([
                'msg' => '所需图片不存在！',
                'errorCode' => 20002,
            ]);
        }

        $this->detailImg = $data;
    }

    /**
     * 根据图片ID获取图片
     * @param $ids
     * @return false|null|static|static[]
     * @throws Exception
     * @throws ProductMiss
     */
    private function getImgs($ids){
        if( empty($ids) ){
            throw new Exception(['msg' => '传入的图片ID不能为空']);
        }

        if( is_array($ids) ){
            $imgs = ImageModel::all($ids);
        }else{
            $imgs = ImageModel::get($ids);
        }

        if(!$imgs){
            throw new ProductMiss([
                'msg' => '所需图片不存在！',
                'errorCode' => 20002,
            ]);
        }

        return $imgs;
    }

    /**
     * 创建或修改商品
     * @param array $data
     * @return false|int|mixed
     */
    private function saveProductData($data = []){
        // 如果有产品ID，则修改该产品，没有则创建
        if($data['id']){
            $product = ProductModel::get($data['id']);
            return $product->save($data);
        }

        $product = ProductModel::create($data);
        return $product->id;
    }
}
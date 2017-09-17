<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

use think\Route;

// Banner
Route::get('/api/:version/banner/:id/', 'api/:version.Banner/getBanner'); // 获取特定banner位下的banner items

// Theme
Route::get('/api/:version/theme/:id/', 'api/:version.Theme/theme');  // 获取特定主题及其下的商品，可分页
Route::get('/api/:version/theme/','api/:version.Theme/getSimpleList'); // 根据ids获取几个主题

// Product
Route::get('/api/:version/product/recent','api/:version.Product/getRecent'); // 获取最新商品，可分页
Route::get('/api/:version/product/cate/:cid','api/:version.Product/getCategoryItems'); // 获取一个分类及其下商品，可分页
Route::get('/api/:version/product/:id','api/:version.Product/getProductDetail'); // 获取一个商品详细
Route::post('/api/:version/product/create','api/:version.Product/createProduct'); // 新增商品
Route::post('/api/:version/product/update','api/:version.Product/updateProduct'); // 新增商品

// Category
Route::get('/api/:version/category/all','api/:version.Category/getAll'); // 获取所有分类

// MiniappToken
Route::post('/api/:version/token/miniapp','api/:version.Token/miniappToken'); // 给小程序颁发token

// UserAddress
Route::post('/api/:version/address/:id','api/:version.UserAddress/edit'); // 修改地址
Route::post('/api/:version/address','api/:version.UserAddress/create'); // 添加地址
Route::get('/api/:version/address','api/:version.UserAddress/getAll'); // 获取用户所有地址
Route::put('/api/:version/address/:id','api/:version.UserAddress/setDefault'); // 设置为默认地址
Route::delete('/api/:version/address/:id','api/:version.UserAddress/delete'); // 删除一条地址

// Order
Route::post('/api/:version/order','api/:version.Order/placeOrder'); // 创建订单
Route::get('/api/:version/order/:No','api/:version.Order/getOne'); // 查询一个订单
Route::get('/api/:version/order','api/:version.Order/getByPage'); // 订单分页

// Upload
Route::post('/api/:version/upload/img','api/:version.Upload/img'); // 上传图片
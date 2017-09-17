<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 07/08/2017
 * Time: 22:25
 */

namespace app\api\service;


class BaseService
{
    /**
     * 对比新旧记录集
     * @param $newRecords     // 新记录集
     * @param $originRecords  // 旧记录集
     * @param $key            // 对比依据
     * @param $keeps          // 更新时，需要保留的字段
     * @param $drops          // 新增时，需要去除的字段
     * @return array
     */
    protected function differRecords($newRecords, $originRecords, $key, $keeps = [], $drops = []){
        $data = [
            'create' => [], // 需要新增的记录
            'update' => [], // 需要更新的记录
            'delete' => [], // 需要删除的记录
        ];

        foreach ( $newRecords as $new ){
            $isExist = false; // 该是否已存在

            foreach ( $originRecords as &$origin ){
                if ( $new[$key] == $origin[$key] ){

                    foreach ($keeps as $keep){
                        // 留下原记录中需要保留的字段
                        $new[$keep] = $origin[$keep];
                    }
                    $data['update'][] = $new;

                    $isExist = true; // 标记记录已存在
                    $origin['_checked'] = true; // 标记原始记录将被更新
                }
            }

            if ( !$isExist ){
                // 新增时，需要去除的字段
                foreach ($drops as $drop){
                    unset($new[$drop]);
                }
                $data['create'][] = $new;
            }
        }

        foreach ( $originRecords as $origin ){
            if ( !$origin['_checked'] ){
                $data['delete'][] = $origin;
            }
        }

        return $data;
    }
}
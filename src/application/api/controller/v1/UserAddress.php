<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 18:12
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\validate\UserAddress as AddressValidate;
use app\api\model\UserAddress as AddressModel;
use app\lib\exception\AddressMiss;
use app\lib\exception\ReturnSuccess;
use app\lib\exception\UserMiss;

class UserAddress extends BaseController
{
    // 前置操作
    protected $beforeActionList = [
        'checkUserToken',
        'checkUserPrimaryScope',
    ];

    public function create(){
        // 验证数据
        $validate = new AddressValidate();
        $validate->scene('create');
        $validate->goCheck();

        // 获取数据
        $data = $validate->getCurrentData();

        // 新增地址
        $user = UserModel::get($this->uid);
        if( !$user ){
            throw new UserMiss();
        }
        $user->address()->save($data);

        return ['msg' => 'success'];
    }

    public function edit(){
        // 验证数据
        $validate = new AddressValidate();
        $validate->scene('edit');
        $validate->goCheck();

        // 获取数据
        $data = $validate->getCurrentData();
        $result = AddressModel::updateByUser($this->uid, $data['id'], $data);

        if( !$result ){
            throw new AddressMiss([
                'httpCode' => 403,
                'msg' => '地址未修改',
                'errorCode' => 70002,
            ]);
        }

        return ['msg' => 'success'];
    }

    public function getAll(){
        return AddressModel::getAllByUser($this->uid);
    }

    public function setDefault($id){
        (new AddressValidate())->scene('setDefault')->goCheck();
        AddressModel::setDefault($this->uid, $id);

        return ['msg' => 'success'];
    }

    public function delete($id = null){
        (new AddressValidate())->scene('delete')->goCheck();
        AddressModel::deleteByUser($this->uid, $id);

        return ['msg' => 'success'];
    }
}
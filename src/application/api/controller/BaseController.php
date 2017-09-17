<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 31/07/2017
 * Time: 21:14
 */

namespace app\api\controller;


use app\lib\enum\ScopeEnum;
use app\lib\exception\UserMiss;
use think\Controller;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;

class BaseController extends Controller
{
    protected $uid;

    /**
     * 检查用户token
     * @throws UserMiss
     */
    protected function checkUserToken(){
        // 检查该用户是否存在
        $uid = TokenService::getCurrentUID();
        $this->uid = $uid;
    }

    /**
     * 检查最低权限
     */
    protected function checkUserPrimaryScope(){
        TokenService::needPrimaryScope(ScopeEnum::User);
    }

    /**
     * 检查独占权限
     */
    protected function checkUserExclusiveScope(){
        TokenService::needExclusiveScope(ScopeEnum::User);
    }
}
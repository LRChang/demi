<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 29/07/2017
 * Time: 12:40
 */

namespace app\api\controller\v1;

use app\api\validate\Token as TokenValidate;
use app\api\service\MiniappToken as MiniappTokenService;

class Token
{
    public function miniappToken($code = ''){
        (new TokenValidate())->scene('miniapp')->goCheck();

        $service = new MiniappTokenService($code);
        $token = $service->get();

        return ['token'=>$token];
    }
}
<?php


namespace app\service;


use app\exception\TokenException;
use think\facade\Request;

class UserToken extends Token
{
    public function get($user) {
        // $user = $this->checkUser();
        $cacheValue = $this->getCatchValue($user);
        return $this->saveToCatch($cacheValue);
    }

//    public function checkUser() {
//        $params = Request::only(['account', 'password'],'get');
//        $user = UserModel::get($params);
//        var_dump($user)
//        if(!$user) {
//            throw new UserException();
//        }
//        return $user;
//    }

    public function getCatchValue($user) {
        $cacheValue = [];
        $cacheValue['id'] = $user->id;
        $cacheValue['account'] = $user->account;
        $cacheValue['scope'] = $user->scope;
        return $cacheValue;
    }

    public function verify() {
        $token = Request::header('Access-Token');
        if($res = cache($token))
            return $res;
        return null;
    }

    // param $key 为空时获取整个token数组
    static function getTokenInfo($key = null) {
        $token = Request::header('Access-Token');

        if($res = cache($token)) {
            $res = json_decode($res, true);
            if($key) {
                return $res[$key];
            }
            return $res;
        }
        throw new TokenException();
    }
}
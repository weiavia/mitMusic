<?php


namespace app\service;


use think\Exception;

class Token
{
    public static function generateToken()
    {
        // 三种随机字符串的md5加密
        $randChar = getRandChars(32);
        $rTime = $_SERVER["REQUEST_TIME"];
        $salt = config('token.salt');
        return md5($randChar.$rTime.$salt);
    }

    public function saveToCatch($value){
        $key = $this->generateToken();
        $value = json_encode($value);
        $expire = config('token.token_expire_in');

        $result = cache($key,$value,$expire);
        if(!$result){
            throw new Exception('缓存生成失败');
        }
        return $key;
    }

}
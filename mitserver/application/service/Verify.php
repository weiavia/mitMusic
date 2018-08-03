<?php


namespace app\service;


use think\Facade\Request;


class Verify
{
    static function check() {
        $params = \think\facade\Request::only(['ticket', 'randStr']);
        $params['aid'] = config('verify.aid');
        $params['appsecretkey'] = config('verify.AppSecretKey');
        $params['UserIP'] = '211.142.228.162';
        var_dump($params);
        $url = config('verify.url');
        $result = curl_post($url, $params);
        var_dump($result);
        exit();
        return true;
    }
}
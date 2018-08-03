<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function curl($url, $refresh = '') {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REFERER, $refresh);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function curl_post($url, $data) {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}


// url参数合并
function mergeUrl($url, $params = []) {
    $pm = '';
    foreach ($params as $key=>$val) {
        $pm.=$key.'='.$val.'&';
    }
    $pm = substr($pm, 0, strlen($pm)-1);
    $url = $url.(strpos($url, '?') ? '&' : '?').$pm;
    return $url;
}

// 生成随机字符串
function getRandChars($length)
{
    $str = 'QWERTYUIOPASDFGHJKLMNBVXZCqwetryuioplkjhgfdaszxcvbnm09876543123';
    $strLength = count($str) - 1;
    $result = '';

    for($i=0; $i<$length; $i++){
        $result.= $str[rand(0,$strLength)];
    }
    return $result;
}


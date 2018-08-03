<?php


namespace app\service;


use think\Exception;
use think\facade\Request;

class Song
{
    static function getLyric() {
        $param = Request::only(['songmid'], 'get');
        $url = config('song.lyricUrl');
        $url = mergeUrl($url, $param);
        $refresh = config('songlist.refresh');
        $result = curl($url, $refresh);

        if (!$result) {
            throw new Exception('getLyric api 请求失败');
        }

        if (preg_match('/^\w+\(({.+})\)$/', $result, $matches)) {
            return json_decode($matches[1], true);
        }
        return [];
    }
}
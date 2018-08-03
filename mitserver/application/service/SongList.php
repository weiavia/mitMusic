<?php

namespace app\service;

use think\Exception;
use think\facade\Request;

class SongList
{
    static function getSongList()
    {

        $url = config('songlist.getUrl');
        $param = Request::only(['ein', 'sin'], 'get');
        $url = mergeUrl($url, $param);
        $refresh = config('songlist.refresh');
        $result = curl($url, $refresh);

        if (!$result) {
            throw new Exception('songlist api 请求失败');
        }

        if (preg_match('/^\w+\(({[^()]+})\)$/', $result, $matches)) {
            return json_decode($matches[1], true);
        }
        return [];
    }

    static function getListInfo()
    {
        $url = config('songlist.listInfoUrl');
        $oParam = Request::only(['dissid'], 'get');
        $param = ['disstid' => $oParam['dissid']];
        $url = mergeUrl($url, $param);

        $refresh = config('songlist.refresh');
        $result = curl($url, $refresh);

        if (!$result) {
            throw new Exception('listInfo api 请求失败');
        }

        if (preg_match('/^\w+\(({.+})\)$/', $result, $matches)) {
            return json_decode($matches[1], true);
        }
        return [];
    }
}
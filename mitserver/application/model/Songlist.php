<?php

namespace app\model;

use app\service\UserToken;
use think\Exception;
use think\facade\Request;
use app\model\Songandlist;
use app\model\Song;

class Songlist extends Base
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;

    public function createOne()
    {
        $params = Request::only(['type', 'name']);
        $params['uid'] = UserToken::getTokenInfo('id');
        $result = self::create($params);
        if (!$result) {
            throw new Exception('字段写入数据库失败');
        }
        return $result;
    }

    public function createFavorite($uid) {
        $params = [
            'uid'=> $uid,
            'name'=> '我喜欢',
            'type'=> 3
        ];
        $result = self::create($params);
        if (!$result) {
            throw new Exception('字段写入数据库失败');
        }
        return $result;
    }

    // return listid
    static function findByUidAndListId()
    {
        $uid = UserToken::getTokenInfo('id');
        $listId = '';
        $data = Request::only(['listid']);
        if(array_key_exists('listid', $data)) {
            $listId = $data['listid'];
        }

        if(!$listId) {
            $listId = self::getFavorite($uid)->id;
        }

        $res = self::where('uid','=',$uid)
            ->where('id', '=', $listId)
            ->find();

        if($res) {
            return $listId;
        }
        return null;
    }

    static function selectByUid($uid)
    {
        $list = self::where('uid', '=', $uid)->select();
        return self::getAvatar($list);
    }

    static function selectByType($type = 1)
    {
        $list = self::where('type', '=', $type)->select();
        return self::getAvatar($list);
    }

    static function selectUserList($uid) {
        $list = self::where('uid', '=', $uid)->where('type', '=', 2)->select();
        return self::getAvatar($list);
    }

    public function songs()
    {
        return $this->belongsToMany('Song', 'Songandlist', 'songid', 'listid');
    }

    static function getAvatar($list)
    {
        foreach ($list as $val) {
            if ($val->avatar === "" || $val->avatar === null) {
                $firstSong = Songandlist::getFirstSong($val->id);
                if (empty($firstSong[0])) {
                    break;
                }
                $firstSongId = $firstSong[0]->songid;
                $avatar = Song::get($firstSongId)->avatar;
                $val->avatar = $avatar;
            }
        }
        return $list;
    }

    static function getFavorite($uid) {
        return self::where('uid', '=', $uid)
            ->where('type', '=', 3)
            ->find();
    }
}
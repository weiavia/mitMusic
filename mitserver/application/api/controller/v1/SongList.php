<?php

namespace app\api\controller\v1;

use app\exception\ResourceNotFindException;
use app\service\SongList as songListService;
use app\service\UserToken;
use app\validate\SongList as songListValidate;
use app\validate\Song as songValidate;
use app\model\Songlist as songListModel;
use app\model\Song as songModel;
use app\model\Songandlist as songAndListModel;
use think\facade\Request;

class Songlist extends Base
{
    protected $listid = '';

    protected $beforeActionList = [
        'checkUserScope'  =>  ['only'=>''],
        'checkSuperScope'  =>  ['only'=>''],
    ];

    // 获取QQ音乐推荐歌单
    public function getSongList()
    {
        (new songListValidate())->toCheck('songlist');
        $songList = songListService::getSongList();
        if (!$songList) {
            throw new ResourceNotFindException();
        }
        return [
            'errorCode' => 0,
            'data' => $songList
        ];
    }

    // 获取QQ音乐推荐歌单下的歌曲
    public function getListInfo()
    {
        (new songListValidate())->toCheck('listinfo');
        $listInfo = songListService::getListInfo();
        if (!$listInfo) {
            throw new ResourceNotFindException();
        }
        return [
            'errorCode' => 0,
            'data' => $listInfo
        ];
    }

    // 创建歌单
    public function create() {
        $type = Request::only('type', 'post')['type'];
        $type == 1 ? parent::checkSuperScope() : parent::checkUserScope();
        (new songListValidate())->toCheck('create');
        $result = (new songListModel())->createOne();
        return [
            'errorCode' => 0,
            'data'=> $result
        ];
    }

    // 获取歌单通过用户ID
    public function get() {
        $uid = UserToken::getTokenInfo('id');
        $list = songListModel::selectByUid($uid);

        if(!$list) {
            // todo 异常
        }
        return [
            'errorCode'=> 0,
            'data'=> $list
        ];
    }

    // 添加歌曲到歌单，添加中间表的数据
    public function addSongAndList() {
        // 1。验证歌曲字段
        // 2。验证歌单字段 如果没有传listid 那么将歌曲添加到 favorite
        // 3。将歌曲字段存入 mit_song 表中返回 songid
        // 4。然后一同存在 mit_songAndList表
        (new songValidate())->toCheck();
        $song = (new songModel())->createOne();
        $result = (new songAndListModel())->createOne($song->id);
        if(!$result) {
            // todo 异常
        }
        return [
            'errorCode'=> 0,
            'data'=> $result
        ];
    }

    // 从歌单中删除歌曲
    public function removeSong() {
        // 1. 判断歌单是否属于当前用户
        $listid = songListModel::findByUidAndListId();
        if(!$listid) {
            // todo 异常
        }
        $res = (new songAndListModel())->removeOne($listid);
        if(!$res) {
            // 异常
        }
        return [
            'errorCode'=> 0
        ];
    }

    // 获取歌单中的歌曲
    public function getSongs() {
        if(!$this->listid) {
            (new songListValidate())->toCheck('getSongs');
            $this->listid = Request::only(['listid'])['listid'];
        }

        $list = (new songListModel())->get($this->listid);
        if(!$list->songs) {
            // todo 异常
        };
        return [
            'errorCode' => 0,
            'data' => $list->songs
        ];
    }

    // 获取首页默认播放歌单
    public function getIndexDefaultList() {
        $list = (new songListModel())->get(1);
        $songs = $list->songs;
        if(!$songs) {
            // todo 异常
        }
        return [
            'errorCode' => 0,
            'data' => $songs
        ];
    }

    // 获取站长推荐的歌单
    public function getRecommendList() {
        $list = songListModel::selectByType(1);

        if(!$list) {
            // todo 异常
        }
        return [
            'errorCode'=> 0,
            'data'=> $list
        ];
    }

    // 获取用户歌单
    public function getUserSongList() {
        $uid = UserToken::getTokenInfo('id');
        $list = songListModel::selectUserList($uid);
        if(!$list) {
            // 异常
        }
        return [
            'errorCode'=> 0,
            'data'=> $list
        ];
    }

    // 获取用户 favorites 下的歌曲
    public function getFavorites() {
        $uid = UserToken::getTokenInfo('id');
        $this->listid = songListModel::getFavorite($uid)->id;
        return $this->getSongs();
    }
}
<?php

namespace app\model;
use think\Exception;
use think\facade\Request;
use app\service\UserToken;
use app\model\Songlist;
use app\model\Song as SongModel;

class Songandlist extends Base
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;

    public function createOne($songId) {
        $listid = '';
        if(Request::has('listid')){
            $listid = Request::only(['listid'])['listid'];
        } else {
            // 获取当前用户favorite id
            $uid = UserToken::getTokenInfo('id');
            $listid = Songlist::getFavorite($uid)->id;
        }
        $params['listid'] = $listid;
        $params['songid'] = $songId;
        $result = self::create($params);
        if(!$result) {
            throw new Exception('字段写入数据库失败');
        }
        return $result;
    }

    static function getFirstSong($listid) {
        return self::where('listid','=',$listid)->limit(1)->select();
    }

    public function removeOne($listid) {
        $songId = Request::only(['songid'])['songid'];
        // 如果传入的歌曲id是 mid 的放那么通过mid 查找歌曲id

        $songId = SongModel::findByMid($songId)->id;

        return self::where('listid', '=', $listid)
            ->where('songid', '=', $songId)
            ->delete();
    }

}
<?php


namespace app\api\controller\v1;
use app\model\Forum as ForumModel;
use app\service\UserToken;

class Forum extends Base
{
    public function addForum() {
        (new \app\validate\Forum())->toCheck('add');
        $uid = UserToken::getTokenInfo('id');
        $result = (new ForumModel())->createOne($uid);
        if(!$result) {
            // todo 异常
        }
        return [
            'errorCode'=> 0,
            'data'=> $result
        ];
    }

    public function select()
    {
        (new \app\validate\Forum())->toCheck('select');
        $result = ForumModel::selectByLimit();

        if(!$result) {

        }
        return [
            'errorCode'=> 0,
            'data'=> $result
        ];
    }
}
<?php


namespace app\api\controller\v1;
use app\exception\UserException;
use app\service\UserToken;
use app\validate\User as UserValidate;
use app\model\User as UserModel;
use app\model\Songlist as SongListModel;
use think\facade\Request;

class User extends Base
{
    public function Register() {
        (new UserValidate())->toCheck();
        // todo 数据验证 account是否重复
        $user = (new UserModel)->createOne();
        // 直接登录---生成token
        $token = (new UserToken())->get($user);

        // 初始化user数据
        $this->initUser($user->id);

        return [
            'errorCode' => 0,
            'token' => $token,
            'userInfo' => [
                'avatar' => config('user.faceImageUrlPrefix').$user->avatar,
                'username'=> $user->username,
                'account' => $user->account
            ]
        ];
    }

    public function getUserInfo() {
        $uid = UserToken::getTokenInfo('id');

        $user = UserModel::selectInfo($uid);
        return [
            'errorCode'=> 0,
            'data'=> $user
        ];
    }

    public function findAvatar() {
        (new UserValidate())->toCheck('findAvatar');
        $user = (new UserModel)->findByAccount();
        if(!$user) {
            // todo 异常
            throw new UserException([
                'message' => '不存在的用户~'
            ]);
        }
        $urlPrefix = config('url.avatarUrlPrefix');
        return [
            'errorCode' => 0,
            'avatar' => $urlPrefix.$user->avatar,
        ];
    }

    public function initUser($uid) {
        // 创建favorite歌单
        (new SongListModel())->createFavorite($uid);
    }
}
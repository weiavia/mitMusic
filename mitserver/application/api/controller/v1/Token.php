<?php
namespace app\api\controller\v1;

use app\exception\UserException;
use app\validate\Token as TokenValidate;
use app\service\UserToken as TokenService;
use app\model\User as userModel;
use app\Enum\ScopeEnum;
use think\facade\Request;

class Token extends Base
{
    public function getToken()
    {
        (new TokenValidate())->toCheck('get');
        $user = (new userModel())->selectOne();
        if(!$user) {
            throw new UserException();
        }
        // 判断是不是CMS端登录，并且登录者必须有管理员以上权限
        $isCms =  Request::post('cmsFlag');
        if($isCms && $user->scope < ScopeEnum::Manage) {
            throw new UserException([
                'message' => '你没有权限~'
            ]);
        }
        $token = (new TokenService)->get($user);
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

    public function verifyToken()
    {
        // (new TokenValidate())->toCheck('verify');
        $result = (new TokenService)->verify();
        if(!$result) {
            // todo 异常
        }
        return [
            'errorCode' => 0,
            'token' => $result
        ];
    }
}
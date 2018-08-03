<?php


namespace app\api\controller\v1;

use app\Enum\ScopeEnum;
use app\exception\ScopeException;
use app\service\UserToken;
use think\Controller;

class Base extends Controller
{
    public function checkUserScope() {
        $scope = UserToken::getTokenInfo('scope');
        if(!$scope || $scope < ScopeEnum::User)
            throw new ScopeException([
                'message' => '警告：你没有USER 权限！'
            ]);
    }

    public function checkSuperScope() {
        $scope = UserToken::getTokenInfo('scope');
        if(!$scope || $scope < ScopeEnum::Super)
            throw new ScopeException([
                'message' => '警告：你没有SUPER 权限！'
            ]);
    }
}
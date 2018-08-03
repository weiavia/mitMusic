<?php


namespace app\validate;
use app\api\controller\v1\Verify;
use think\Facade\Session;

class User extends Base
{
    protected $rule = [
        'account'  => 'require|number',
        'password'   => 'require',
        'username' => 'require',
    ];

    protected $message = [
        'code' => '验证码错误'
    ];

    protected $scene = [
        'findAvatar' => ['account'],
        'register' => ['account', 'password', 'username']
    ];

}
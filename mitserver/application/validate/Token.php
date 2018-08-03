<?php


namespace app\validate;


class Token extends Base
{
    protected $rule = [
        'account'  => 'require|number',
        'password'   => 'require',
        'token' => 'require'
    ];

    protected $scene = [
        'get' => ['account', 'password'],
        'verify' => ['token']
    ];
}
<?php


namespace app\exception;


class UserException extends BaseException
{
    public $code = 401;
    public $errorCode = 100001;
    public $message = '用户名或密码错误';
}
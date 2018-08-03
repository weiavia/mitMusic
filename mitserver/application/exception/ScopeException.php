<?php


namespace app\exception;


class ScopeException extends BaseException
{
    public $code = 401;
    public $errorCode = 100001;
    public $message = '你没有权限~';
}
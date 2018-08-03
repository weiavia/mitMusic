<?php


namespace app\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $errorCode = 100002;
    public $message = '身份失效';
}
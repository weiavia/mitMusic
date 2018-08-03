<?php


namespace app\exception;


class ResourceNotFindException extends BaseException
{
    public $code = 404;
    public $errorCode = 10001;
    public $message = '资源未找到';
}
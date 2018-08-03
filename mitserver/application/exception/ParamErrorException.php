<?php


namespace app\exception;


class ParamErrorException extends BaseException
{
    public $code = 400;
    public $message = '请求参数错误！';
    public $errorCode = 10000;
}
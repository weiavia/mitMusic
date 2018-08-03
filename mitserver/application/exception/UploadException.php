<?php


namespace app\exception;


use app\model\Base;

class UploadException extends BaseException
{
    public $code = 401;
    public $errorCode = 10002;
    public $message = '文件上传失败';
}
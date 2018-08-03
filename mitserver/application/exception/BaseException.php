<?php

namespace app\exception;


use think\Exception;

class BaseException extends \Exception
{
    public $code;
    public $message;
    public $errorCode;

    public function __construct($custom = [])
    {
        // custom 使用者定制参数,如果不传参数表示使用默认，不是数组抛出异常
        if(!is_array($custom)) {
            throw new Exception('param custom must array');
        }
        if( array_key_exists('code',$custom)) {
            $this->code = $custom['code'];
        }
        if( array_key_exists('errorCode',$custom)) {
            $this->errorCode = $custom['errorCode'];
        }
        if( array_key_exists('message',$custom)) {
            $this->message = $custom['message'];
        }
    }

}
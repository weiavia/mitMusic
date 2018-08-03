<?php

namespace app\exception;

use think\Exception;
use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;

// 继承并重写tp的全局异常处理类
class Handler extends Handle
{
    public $code;
    public $message;
    public $errorCode;

    public function render(\Exception $e)
    {
        if($e instanceof BaseException) {
            $this->code = $e->code;
            $this->message = $e->message;
            $this->errorCode = $e->errorCode;
        } else {
            // 如果是调试模式显示tp的错误页面 否则记录日志
            if(config('app_debug')) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->message = '系统内部错误~';
                $this->errorCode = 999;
                // 记录日志
                $this->recordLog($e);
            }
        }

        return json([
            'errorCode'=> $this->errorCode,
            'message' => $this->message,
            'url' => Request::url()
        ],$this->code);
    }

    public function recordLog(Exception $e) {
        Log::init([
            'type' => 'File',
            'path' => '',
            'level' => ['error']
        ]);
        Log::record($e->getMessage(), 'error');
    }
}
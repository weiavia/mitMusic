<?php


namespace app\api\controller\v1;
use think\captcha\Captcha;

class Verify
{
    public function get() {
        $config =    [
            'imageW' =>    260
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    static function check() {
        (new \app\validate\Verify())->toCheck();
        $result = \app\service\Verify::check();
    }
}
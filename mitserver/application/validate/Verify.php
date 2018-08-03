<?php

namespace app\validate;

class Verify extends Base
{
    protected $rule = [
        'ticket'  => 'require',
        'randStr' => 'require'
    ];
}
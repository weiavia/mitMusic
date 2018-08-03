<?php


namespace app\validate;


class Song extends Base
{
    protected $rule = [
        'mid'  => 'require',
        'name' => 'require',
        'singer' => 'require',
        'avatar' => 'require',
        'url' => ''
    ];

    protected $scene = [
        'lyric' => ['songmid']
    ];
}
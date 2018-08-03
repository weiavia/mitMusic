<?php

namespace app\validate;

class SongList extends Base
{
    protected $rule = [
        'ein'  => 'require|number',
        'sin'   => 'require|number',
        'dissid' => 'require|number',
        'type' => 'require|number',
        'name' => 'require',
        'listid' => 'require'
    ];

    protected $scene = [
        'listinfo' => ['dissid'],
        'songlist' => ['ein', 'sin'],
        'create' => ['type', 'name'],
        'getSongs' => ['listid']
    ];
}
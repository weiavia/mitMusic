<?php


namespace app\validate;


class Forum extends Base
{
    protected $rule = [
        'title'  => 'require',
        'content' => 'require',
        'limit' => 'require',
        'num' => 'require'
    ];

    protected $scene = [
        'select'=> ['limit', 'num'],
        'add'=> ['title', 'content']
    ];

}
<?php


namespace app\api\controller\v1;


use app\exception\ResourceNotFindException;

class Song extends Base
{
    public function getLyric()
    {
        (new \app\validate\Song())->toCheck('lyric');
        $lyric = \app\service\Song::getLyric();
        if (!$lyric) {
            throw new ResourceNotFindException();
        }
        return [
            'errorCode' => 0,
            'data' => $lyric
        ];
    }
}
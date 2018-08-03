<?php

namespace app\model;
use think\facade\Request;

class Song extends Base
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;

    public function createOne() {
      $params = Request::only(['mid', 'name', 'singer', 'avatar', 'url']);
      
      $result = self::create($params);
      if(!$result) {
        throw new Exception('字段写入数据库失败');
      }
      return $result;
    }

    public function songlist() {
      return $this->belongsToMany('Songlist', 'songandlist');
    }

    static function findByMid($mid) {
        return self::where('mid', '=', $mid)->find();
    }

}
<?php

namespace app\model;

use think\facade\Request;
use app\model\User as UserModel;

class Forum extends Base
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;

    public function createOne($uid)
    {
      $params = Request::only(['title', 'content']);
      $params['uid'] = $uid;
      $result = self::create($params);
      if (!$result) {
          throw new \Exception('字段写入数据库失败');
      }
      return $result;
    }

    static function selectByLimit()
    {
        $param = Request::only(['num', 'limit']);
        $res = self::limit($param['limit'], $param['num'])->select();
        foreach ($res as $key=>$val) {
            $user = UserModel::get($val->uid);
            $res[$key]['user'] = $user;
        }
        return $res;
    }

}
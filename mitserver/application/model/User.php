<?php

namespace app\model;
use think\Exception;
use think\facade\Request;

class User extends Base
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;

    public function createOne() {
        $params = Request::only(['username', 'account', 'password', 'url', 'avatar']);
        $params['password'] = md5($params['password']);
        // 先这么写
        $params['scope'] = 16;
        $result = self::create($params);
        if(!$result) {
            throw new Exception('注册字段写入数据库失败');
        }
        return $result;
    }

    public function selectOne() {
        $params = Request::only(['account', 'password']);
        $params['password'] = md5($params['password']);
        return self::where(['account' => $params['account']])
                ->where(['password' => $params['password']])
                ->find();
    }

    public function findByAccount() {
        $params = Request::only(['account']);
        return self::where($params)->find();
    }

    static function selectInfo($uid) {
        $field = [
            'id',
            'account',
            'username',
            'avatar'
        ];
        $user = self::field($field)->where('id','=',$uid)->find();
        $user->avatar = config('user.faceImageUrlPrefix').$user->avatar;
        return $user;
    }

    public function forum()
    {
        return $this->belongsTo('Forum');
    }

//    public function getAvatarAttr($value)
//    {
//        return 'http://mit.api.com/uploads/face/'.$value;
//    }

}
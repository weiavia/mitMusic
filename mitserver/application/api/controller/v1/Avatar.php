<?php


namespace app\api\controller\v1;


use app\exception\UploadException;

class Avatar extends Base
{
    public function upload() {
        $file = request()->file('image');
        $urlPrefix = config('url.avatarUrlPrefix');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( './uploads/face');
        $fileName = '';
        if($info){
            $fileName =  $info->getSaveName();
        }else{
            throw new UploadException([
                'errorCode' => 90001,
                'message' => $file->getError()
            ]);
        }
        return [
            'errorCode' => 0,
            'data' => [
                'url' => $urlPrefix.$fileName,
                'filename' => $fileName
            ]
        ];
    }
}
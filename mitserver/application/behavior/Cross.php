<?php

namespace app\behavior;

use think\Request;

class Cross
{
    public function appInit(Request $request) {

        if($request->isOptions()) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Token');
            header('Access-Control-Allow-Methods: DELETE');
            exit();
        }
    }
}
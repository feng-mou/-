<?php
namespace app\api\controller;

class Index extends AuthBase
{
    public function getRotationChart(){
        if($this->request->isGet()){

            return show(config('status.success'),"请求方式正确");
        }
        return show(config('status.error'),"请求方式错误");
    }
}

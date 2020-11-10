<?php
namespace app\api\controller;
use app\common\business\Category as cmp;
use app\common\lib\Arr;
class Category extends ApiBase
{
    public function index(){
        if($this->request->isGet()){
            $categoryObj = new cmp;
            $data = $categoryObj->cnm();
            $result = Arr::getTree($data);
            $result = Arr::getTree($result);
            halt($result);
            return show(config('status.success'),"请求方式正确",$result);
        }
        return show(config('status.error'),"请求方式错误");
    }
}

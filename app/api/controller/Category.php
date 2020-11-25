<?php
namespace app\api\controller;
use app\common\business\Category as cmp;
use app\common\lib\Arr;
class Category extends ApiBase
{
    public function index(){
        //return 1;
        $categoryObj = new cmp;

        $data = $categoryObj->cnm();
        $res = Arr::getTree($data);
        $result = Arr::sliceTreeArr($res);
        return show(config('status.success'),"OK",$result);
    }
}

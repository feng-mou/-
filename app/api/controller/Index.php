<?php
namespace app\api\controller;
use app\common\business\Goods;
class Index extends ApiBase
{
    public function getRotationChart(){
        $categoryObj = new Goods;

        $result = $categoryObj->getRotationChart();
        dd($result);
        return show(config('status.success'),"请求成功",$result);
    }
}

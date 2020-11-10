<?php
namespace app\admin\controller;
use think\facade\View;
use app\admin\controller\BaseAdmin;
class Specs extends BaseAdmin{

    //渲染index页面
    public function dialog()
    {
        //规格
        return View::fetch('specs/dialog',['specs'=>json_encode(config('specs'))]);
    }
}
?>

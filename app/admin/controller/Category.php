<?php
namespace app\admin\controller;
use think\facade\View;
use app\common\business\Category as categoryModel;
class Category extends BaseAdmin
{
    public function index()
    {
        return View::fetch('category/index');
    }

    //添加页面
    public function add()
    {
        return View::fetch('category/add');
    }

    //添加逻辑
    public function save()
    {
        $pid = input('param.pid');
        $name = input('param.name',"","trim");
        $data = [
            'pid'=>$pid,
            'name'=>$name
        ];
        $validate = new \app\admin\validate\Category;
        if(!$validate->scene('category_add')->check($data)){
            return show(config('status.error'),$validate->getError());
        }
        try{
            //可以用一个变量来接,也可以不用
            $result = (new categoryModel())->add($data);
        }catch(\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        return show(config('status.success'),"添加成功");
        //return show('1',"添加失败");
    }
}

<?php
namespace app\admin\controller;
use think\facade\View;
use app\common\business\Category as categoryModel;
use app\common\lib\Status;
use app\common\lib\Arr;
use think\facade\Log;
class Category extends BaseAdmin
{
    /**
     * 初始页面排序 默认pid从0上级开始,每页分5条数据
     * 优先listorder倒排序如果一样就根据id排倒序
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $pid = input('param.pid',0,"intval");
        $data = [
            'pid'=>$pid
        ];
        //如果没有查到数据就给他设置好的一个空数组
        if(empty($resultList = (new categoryModel())->getList($data,5))){
            log::record("没有数据");
            $resultList = Arr::pagingNo();
        }
        if(empty($breadCrumb = (new categoryModel())->getBreadCrumb($pid))){
            log::record("没有面包");
            $breadCrumb = [];
        }
        return View::fetch('category/index',
            [
                'resultList'=>$resultList,
                'pid'=>$pid,
                'breadCrumb'=>$breadCrumb
            ]);
    }

    //添加页面
    public function add()
    {
        try{
            $result = (new categoryModel())->getCategorys();
        }catch( \Exception $e){
            $result = [];
        }
        return View::fetch('category/add',['category'=>json_encode($result)]);
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


    /**
     * listorder排序
     * 2020.10.2 19:36:29
     * @return \think\response\Json
     */
    public function listorder(){
        $id = input('param.id',0,"intval");
        $listorder = input('param.listorder',0,"intval");

        $data = [
            'id'=>$id,
            'listorder'=>$listorder
        ];
        //用模型判断
        $validate = new \app\admin\validate\Category;
        if(!$validate->scene('category_listorder_edit')->check($data)){

            return show(config('status.error'),$validate->getError());
        }
        //return show(config('status.error'),$validate->getError());

        //修改排序
        try {
            $result = (new categoryModel())->listEdit($id, $listorder);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        return show(config('status.success'),"排序成功");
    }

    /**
     * 修改状态
     * @return \think\response\Json
     */
    public function status(){
        //return show(config("status.error"),"状态参数错误");
        $id = input('param.id',0,"intval");
        $status = input('param.status',0,"intval");
        //$status=9;

        if(!$id || !in_array($status,Status::getStatus())){
            return show(config("status.error"),"状态参数错误");
        }
        //return show(config("status.error"),"hah");
        try {
            $result = (new categoryModel())->statusC($id, $status);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        return show(config('status.success'),"修改状态成功");
    }

    /**
     * 删除分类页面
     * @return \think\response\Json
     */
    public function del(){
        $id = input('param.id',0,"intval");
        $status = input('param.status',0,"intval");
        //$status=9;
        if(!$id || $status!=99){
            return show(config("status.error"),"状态参数错误");
        }
        try{
            $result = (new categoryModel())->userEditStatus($id, $status);
        }catch(\Exception $e){
            return show(config("status.error"),"修改状态是败");
        }
        return show(config('status.success'),"修改状态成功");
    }

    /**
     * 编辑标题
     */
    public function edit(){
        $id = input("param.id");

        try{
            $result = (new categoryModel())->getRes($id);
        }catch( \Exception $e){
            return show("99","没有这数据了",[]);
        }
        //halt($result);
        return View::fetch('category/edit',['result'=>$result]);
    }

    /*
     * 修改逻辑
     * */
    public function xiuGai(){
        if($this->request->isPost()) {
            $id = input('param.id', 0, 'intval');
            $name = input('param.name', "", "trim");
            $res = (new categoryModel())->xiuGai($id,$name);
            if($res){
                return show("1", "修改成功");
            }
            return show(0, "修改成功");
        }
        return show("0","请求方式错误");
    }

    //获取1级分类
    public function dialog(){
        $pid = input('param.pid', 0 ,'intval');
        $result = (new categoryModel())->getPidS($pid);
        return View::fetch('category/dialog',['result'=>json_encode($result)]);
    }

    //获取2,3级分类
    public function getByPid(){
        $pid = input('param.pid', 0 ,'intval');
        //获取1级分类下面的儿子
        $result = (new categoryModel())->getPidErZi($pid);
        return show(config('status.success'),"OK",$result);
        //return View::fetch('category/dialog',['result'=>json_encode($result)]);
    }

}

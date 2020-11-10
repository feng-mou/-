<?php
namespace app\admin\controller;
use app\common\business\Goods as GoodsModel;
use think\facade\View;
use app\common\lib\Arr;
class Goods extends BaseAdmin{
    //渲染index页面
    public function index()
    {
        $data = [];
        $time = input('param.time');
        $title = input('param.title');
        if(!empty($time)){
            $strKaiShi = trim(substr($time, 0, 20));//开始位置
            $strJieShu = trim(substr($time, 21));//开始位置
            $data['time'][0] = $strKaiShi;
            $data['time'][1] = $strJieShu;
            dump($strKaiShi);
            dump($strJieShu);
        }
        if(!empty($title)){
            $data['title'] = $title;
        }
        //dump($data);

        if(empty($resultList = (new GoodsModel())->getList($data,5))){
            $resultList = Arr::pagingNo();
        }

//        //http_build_query()函数的作用是使用给出的关联（或下标）数组生成一个经过 URL-encode 的请求字符串。
//        $queryCanShu = http_build_query(['title'=>$title,'time'=>$time,]);
        return View::fetch('goods/index',
            [
                'resultList'=>$resultList,
                'title'=>$title,
                'time'=>$time,
//                'queryCanShu'=>$queryCanShu
            ]);
    }

    public function add(){
        return View::fetch('goods/add');
    }

    public function save(){
        if($this->request->isPost()){
            $data = input('post.');
            //数据处理
//            $check = $this->request->checkToken('__token__');
//            if($check === false) {
//                return show(config('status.error'),"请求方式错误");
//            }
            $data['category_path_id'] = $data['category_id'];
            $result = explode(',',$data['category_id']);
            $data['category_id'] = end($result);
            $res = (new \app\common\business\Goods())->insertData($data);
           if(!$res){
               return show(config('status.error'),"插入失败");
           }
            return show(config('status.success'),"插入成功",$data);
        }
        return show(config('status.error'),"请求方式错误");

    }

    /**
     * 修改goods和goods_sku表的状态为删除状态
     * @return \think\response\Json
     */
    public function delList(){
        $id = input('param.id',0,'intval');
        try {
            $result = (new \app\common\business\Goods())->delGoodsGoods_skuStatus($id);
        }catch (\Exception $e){
            return show(config('status.error'),'数据库表内容删除失败');
        }
        return show(config('status.success'),"删除成功");
    }

    /**
     * 垃圾排序方法无法响应
     */
    public function listorder(){
        $listorder = input('param.listorder');
        $id = input('param.id',0,'intval');
        try {
            $res = (new \app\common\business\Goods())->updateListorder($id, $listorder);
        }catch(\Exception $e){
            return show(config('status.error'),"无法修改排序");
        }
        return show(config('status.success'),"修改排序成功");
    }


    /**
     * 是否启用状态
     * @return \think\response\Json
     */
    public function status(){
        $id = input('param.id',0,"intval");
        $status = input('param.status');
        try{
            $result = (new \app\common\business\Goods())->updateStatus($id,$status);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        return show(config('status.success'),"修改成功");
    }

    /**
     * is_index_recommend修改状态
     * @return \think\response\Json
     */
    public function is_index_recommend_status(){
        $id = input('param.id',0,"intval");
        //is_index_recommend状态
        $status = input('param.status');
        try{
            $result = (new \app\common\business\Goods())->is_index_recommend_status($id,$status);
        }catch (\Exception $e){
            return show(config('status.error'),$e->getMessage());
        }
        return show(config('status.success'),"修改成功");
    }

}
?>

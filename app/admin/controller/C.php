<?php
namespace app\admin\controller;
use think\facade\View;
use app\common\business\Goods as GoodsBis;
class C extends BaseAdmin{

    public function save(){
        if($this->request->isPost()){
            $data = input('param.');

            //数据处理
            $data['category_path_id'] = $data['category_id'];
            $result = explode(',',$data['category_id']);
            $data['category_id'] = end($result);
            halt($data);
            try{
                $res = (new GoodsBis())->insertData($data);
            }catch (\Exception $e){
                return show(config('status.error'),$e->getMessage());
            }
            halt($res);exit;
            return show(config('status.success'),"插入成功",$data);
        }
        return show(config('status.error'),"请求方式错误");

    }

}
?>

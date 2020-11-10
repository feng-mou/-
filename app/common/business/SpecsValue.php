<?php
namespace app\common\business;
use think\Exception;
use think\facade\Log;
class SpecsValue{
    //用来指定公共模型的
    public $model = null;
    public function __construct()
    {
        $this->model=new \app\common\model\mysql\SpecsValue;
    }

    /**
     * 获取规格分类下的属性值
     * @param $specs_id
     * @return array
     */
    public function getSpecs($specs_id){
        $status = 1;
        try{
            $res = $this->model->getSpecsResult($specs_id,$status);
        }catch(\Exception $e){
            $res = [];
        }
        $result = $res->toArray();
        return $result;
    }

    public function specsAdd($specs_id,$name){

        $bool = $this->model->getSpecs($specs_id,$name);
        if($bool){
            log::record("当前规格属性已经存在");
            throw new Exception("但前规格属性已经存在");
        }
        try{
            $res = $this->model->specsAddShuXin($specs_id,$name);
        }catch(\Exception $e){
            log::record("添加失败");
            throw new Exception("添加失败");
        }
        return true;
    }
}

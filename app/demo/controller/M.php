<?php 
    namespace app\demo\controller;
    use app\BaseController;  
    use app\common\business\TestModel;
    class M extends BaseController
    {
        public function index(){
            //参数转换
            $status_id=$this->request->param('id',0,"intval");
            
            if(empty($status_id)){
                return show(config('status.error'),"没有参数");
            }
            
            //tp6_test的模型
            $obj = new TestModel();
            $result = $obj->getTestModelTp6_testCategoryId($status_id,$limit=5);
            //dd($result);
            return $result;
        }
        
        public function sm()
        {   
            //echo $abc;
            throw new \think\exception\HttpException(404, "找不到相应数据");
        }
    }
    
?>
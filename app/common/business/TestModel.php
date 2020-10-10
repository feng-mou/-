<?php 
    namespace app\common\business;
    use app\common\model\mysql\TestModel as Test;
    class TestModel
    {
        public function getTestModelTp6_testCategoryId($status_id,$limit=10)
        {
            $obj = new Test();
            $result = $obj->getTestModelTp6_testCategoryId($status_id,$limit=10);
            
            if(empty($result->toArray()))
            {
                return show(config('status.success'),"数据为空");
            }
            
            $mofa = config("cc");
            foreach($result as $key=>$results){
                //简单地赋值过去
                $result[$key]['bumeng']=$mofa[$results["status"]] ?? "其他";
            }
            
            return show(config('status.success'),"OK了",$result);
        }
    }
?>
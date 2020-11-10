<?php
    namespace app\admin\controller;
    use app\common\business\SpecsValue as acg;
    class SpecsValue extends BaseAdmin{
        /**
         *获取规格下的属性
         * @return \think\response\Json
         */
        public function getBySpecsId(){
            $specs_id = input('param.specs_id', 0 ,'intval');
            $result = (new acg())->getSpecs($specs_id);
            return show(config('status.success'),"OK",$result);
        }

        /**
         * 添加规格属性
         * @return \think\response\Json
         */
        public function save(){
            $specs_id = input('param.specs_id', 0 ,'intval');
            $name = input('param.name');

            //把值放入数组
            $cc=[
                'specs_id'=>$specs_id,
                'name'=>$name,
            ];
            //使用tp6的validate验证是否合法机制
            $validate = new \app\admin\validate\SpecsValue;
            if(!$validate->scene('specs_add')->check($cc)){
                return show(config("status.error"),$validate->getError());
            }
            try{
                $result = (new acg())->specsAdd($specs_id,$name);
            }catch (\Exception $e){
                return show(config('status.error'),$e->getMessage());
            }
            return show(config('status.success'),"添加成功");

        }
    }

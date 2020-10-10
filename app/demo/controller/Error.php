<?php
    /*
     * @控制器不存在方法
     * date2020.9.20 
     * time16:00
     * */
    namespace app\demo\controller;
    class Error
    {
        public function __call($name,$arguments)
        {
            $result = [
                'status'=>config('status.controller_not_found'),
                'message'=>'找不到该控制器',
                'result'=>null
            ];
            return json($result,400);
        }
    }
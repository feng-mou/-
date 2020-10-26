<?php
    namespace app\api\controller;
    class Logout extends AuthBase {
        public function index(){
            $result =  cache(config('redis_name.login_token').$this->accessToken,null);
            if($result){
                return show(config('status.success'),"退出登录成功");
            }
            return show('status.error',"退出登录失败");
        }
    }

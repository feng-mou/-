<?php
    namespace app\common\lib;
    class Login_token_time{
        //登录token时间
        /*
         * 为传来的值,1为7天,2为30天
         * @param $type
         */
        public static function getLoginTokenTime($type = 2){
            //1为7天,不然默认30天
            $type = !in_array($type,[1,2])? 2 : $type;
            if($type==1){
                $time = $type * 7;
            }else{
                $time = $type * 30;
            }
           return $time * 24 * 3600;
        }
    }

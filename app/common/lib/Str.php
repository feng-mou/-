<?php
    namespace app\common\lib;
    class Str
    {
        /**
         *登录token的生成
         * @param $string 传来的手机号
         * return $string
         */
        public static function loginToken($string){
            //生成token
            $str = md5(uniqid(md5(microtime(true)),true));
            $token = sha1($str.$string);
            return $token;
        }
    }

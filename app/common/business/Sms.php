<?php
    //强类型严格模式
    declare (strict_types = 1);
    namespace app\common\business;
    use app\common\lib\sms\AliSms;
    use app\common\lib\Num;
    class Sms{
        //必须返回布尔类型
        public static function sendCode(string $phoneNumber ,int $len) :bool{
            //生成验证码
            //return true;
            $code=Num::getCode($len);


            //dd($code);
            $obj = new AliSms();
            $res = $obj->aliSms($phoneNumber, $code);
            //$res是一个布尔类型直接返回就可以了
            if($res){
                cache(config('redis_name.phone').$phoneNumber,$code,config('redis_name.phone_time'));
                //return $res;
            }
            return $res;
        }
    }

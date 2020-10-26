<?php
    //强类型严格模式
    declare (strict_types = 1);
    namespace app\common\business;
    //阿里云短信
    //use app\common\lib\sms\AliSms;
    use app\common\lib\Num;
    use app\common\lib\ClassArr;
    class Sms{
        //必须返回布尔类型
        public static function sendCode(string $phoneNumber ,int $len ,string $type) :bool{
            //生成验证码
            $code=Num::getCode($len);
            //$obj = new AliSms();
            //$res = $obj->sendCode($phoneNumber, $code);
            //$res是一个布尔类型直接返回就可以了

            //简单的工厂模式
            //ucfirst()将首字母大写,\"定界符
//            $type = ucfirst($type);
//            $class = "app\common\lib\sms\\".$type."Sms";
//            $res = $class::sendCode($phoneNumber, $code);

            //获取所有短信实例化路径
            $result = ClassArr::smsClassStat();
            //拿到实例化路径
            $classObj = ClassArr::initClass($type,$result);
            //请求发送短信
            $res = $classObj::sendCode($phoneNumber, $code);

            if($res){
                cache(config('redis_name.phone').$phoneNumber,$code,config('redis_name.phone_time'));
                //return $res;
            }
            return $res;
        }
    }

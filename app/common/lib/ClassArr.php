<?php
    namespace app\common\lib;
    class ClassArr {

        //用来取的
        public static function smsClassStat(){
            return [
                'ali'=>"app\common\lib\sms\AliSms",
                'jd'=>"app\common\lib\sms\JdSms",
                'tx'=>"app\common\lib\sms\TxSms",
            ];
        }
        //返回数据的对象或者类库

        /**
         * @param $type   关联下标的东西
         * @param $classs 为smsClassStat方法里面的所有数据
         * @param array $params 默认为空就可以了
         * @param bool $needInstance true为实例化,false为不实例化
         * @return bool|\ReflectionClass
         * @throws \ReflectionException
         */
        public static function initClass($type , $classs,$params = [], $needInstance = false)
        {
            //判断数据里面是否有这东西,没有为返回false失败
            if(!array_key_exists($type,$classs)){
                return false;
            }
            $className = $classs[$type];

            //new ReflectionClass('A')=>建立A反射类
            //->newInstanceArgs($args)=>相当于实例化A类
            return $needInstance = true ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
        }
    }

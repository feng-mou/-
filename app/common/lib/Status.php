<?php
    namespace app\common\lib;

    //获取成员
    class Status{
        public static function getStatus(){
            $status = config('status.mysql');
            //array_values()获取value值
            return array_values($status);
        }
    }

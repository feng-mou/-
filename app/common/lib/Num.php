<?php
    declare(strict_types=1);
    namespace app\common\lib;
    /**
     * 专门写数字的基础类库
     * Class Num
     * @package app\common\lib
     */
    class Num
    {
        public static function getCode(int $len) :int{
            $code = rand(1000,9999);
            if($len == 6){
                $code = rand(100000,999999);
            }
            return $code;
        }
    }

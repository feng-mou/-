<?php
    namespace app\api\validate;
    use think\Validate;
    class USer extends Validate{
        protected $rule = [
            'username'=>'require',
            'phone_number'=>'require|mobile|number|length:11'
        ];
        protected $message = [
            'username'=>'账号不能为空',
            'phone_number.require'=>'手机号不能为空',
            'phone_number.mobile'  => '填写有效的手机',
            'phone_number.number'  => '手机只能数字',
            'phone_number.length'  => '手机只能11位数字',
        ];
        //只校验指定对象
        protected $scene = [
            'send_code'=>['phone_number']
        ];
    }

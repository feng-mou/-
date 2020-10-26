<?php
    namespace app\api\validate;
    use think\Validate;
    class USer extends Validate{
        protected $rule = [
            'username'=>'require',
            'phone_number'=>'require|mobile|number|length:11',
            'code'=>'require|number|length:6',
            'type'=>'require|in:1,2',
            'sex'=>'require|in:0,1,2'
        ];
        protected $message = [
            'username.require'=>'账号不能为空',
            'phone_number.require'=>'手机号不能为空',
            'phone_number.mobile'  => '不能填无效手机号',
            'phone_number.number'  => '手机只能数字',
            'phone_number.length'  => '手机只能11位数字',
            'code.require'=>'验证码不能为空',
            'code.number'=>'验证码只能为数字',
            'code.length'=>'验证码长度必须为6位',
            'type.require'=>'类型必须有',
            'type.in'=>'类型数值错误',
            'sex.require'=>"性别必须",
            'sex.in'=>'性别数值错误'
        ];
        //只校验指定对象
        protected $scene = [
            //验证码参数校验
            'send_code'=>['phone_number'],
            //登录参数校验
            'login'=>['phone_number','code','type'],
            //修改参数校验
            'update_user'=>['username','sex']
        ];
    }

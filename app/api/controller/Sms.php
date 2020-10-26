<?php
    declare(strict_types=1);
    namespace app\api\controller;
    use app\BaseController;
    use think\exception\ValidateException;
    use app\common\business\Sms as Gg;
    class Sms extends BaseController{
        public function code() :object{
            //接收参数
            $phoneNumber = input('param.phone_number','','trim');
            $data=[
                'phone_number'=>$phoneNumber
            ];
            try {
                //validate判断 只判断send_code指定的
                validate(\app\api\validate\User::class)->scene('send_code')->check($data);
            }catch ( \think\Exception\ValidateException $e ) {
                //??
                return show(config("status.error"),$e->getError());
            }
            //$obj=new Gg();
            if(Gg::sendCode($phoneNumber,6,"ali")){
                return show(config("status.success"),"成功发送短信");
            }
            return show(config("status.error"),"一天只能发10次短信");
//            $a = rand(0,99);
//            if($a < 80) {
//                // 阿里云逻辑
//            } else {
//                // 百度云逻辑
//            }
        }

    }

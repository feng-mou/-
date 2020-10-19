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
                //validate判断
                validate(\app\api\validate\User::class)->scene('send_code')->check($data);
            }catch ( \think\Exception\ValidateException $e ) {
                //??
                return json(['status' => config("status.error"), 'massage' => $e->getError()]);
            }
            //$obj=new Gg();
            if(Gg::sendCode($phoneNumber,6)){
                return json(['status'=>config("status.success"),'massage'=>"成功发送短信"]);
            }
            return json(['status'=>config("status.error"),'massage'=>"发送短信失败"]);
        }
    }

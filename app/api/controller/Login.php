<?php
    namespace app\api\controller;
    use app\BaseController;
    use think\Exception;

    class Login extends BaseController
    {
        /**
         * 前端登录接口
         * @return \think\response\Json
         */
        public function index(){
            if(!$this->request->isPost()){
                return show(config("status.error"),"非法请求");
            }
            //接收参数
            //return false;
            $phoneNumber = input('param.phone_number','','trim');
            $code=input('param.code',0,'intval');
            //1为7天,2为30天默认
            $type=input('param.type',0,'intval');
            $data=[
                'phone_number'=>$phoneNumber,
                'code'=>$code,
                'type'=>$type
            ];

            try {
                //validate判断 只判断send_code指定的
                validate(\app\api\validate\User::class)->scene('login')->check($data);

            }catch ( \think\Exception\ValidateException $e ) {
                return show(config("status.error"),$e->getError());
            }
            //实例化顺便使用方法传值
            try{
                $res = (new \app\common\business\User())->login($data);
            }catch( \think\Exception $msg){
                return show(config("status.error"),$msg->getMessage());
            }

            if($res){
                return show(config("status.success"),"登录成功",$res);
            }
            return show(config("status.error"),"登录失败");
        }

        public function dd(){
            $result = json(['status'=>'error','massage'=>"错误",'[]','httpsSt'=>200]);
            $cc = show('error',"测试");
            dump($result);
            echo "<br/>";
            dump($cc);
            //echo config("redis_name.login_token");
        }
    }



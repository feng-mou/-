<?php
    namespace app\admin\controller;
    use think\facade\View;
    use think\captcha\facade\Captcha;
    use app\admin\controller\BaseAdmin;
    use app\admin\model\mysql\AdminUser;
    //引入云通信
    use app\common\lib\Ytx;
    class Login extends BaseAdmin{

        public function index()
        {
            return View::fetch('login/index');
        }

        //登入验证
        public function check(){
            if(!$this->request->isPost()){
                return show(config("status.error"),"请求错误");
                //return json(['status'=>config("status.error"),'msg'=>"请求错误"]);
            }
            //param第一个参数为传来的name名,二为不知道,3为过滤
            $username = $this->request->param("username","","trim");
            $password = $this->request->param("password","","trim");
            $captcha = $this->request->param("captcha","","trim");

            //把值放入数组
            $cc=[
                'username'=>$username,
                'password'=>$password,
                'captcha'=>$captcha,
            ];
            //使用tp6的validate验证是否合法机制
            $validate = new \app\admin\validate\AdminUser;
            if(!$validate->check($cc)){
                return show(config("status.error"),$validate->getError());
                //return json(['status'=>config("status.error"),'msg'=>$validate->getError()]);
            }

            /*if(empty($username) || empty($password) || empty($captcha)){
                return json(['status'=>config("status.error"),'msg'=>" 参数错误"]);
            }*/

            //把app目录下面的middleware.php文件的Session初始化\think\middleware\SessionInit::class打开

            if(!captcha_check($captcha)){
                return show(config("status.error"),"验证码错误");
                //return json(['status'=>config("status.error"),'msg'=>"验证码错误"]);
            }
            try{
                $AdminUserObj=new \app\admin\business\AdminUser();
                $result = $AdminUserObj->login($cc);
            } catch (\Exception $e){
                return show(config("status.error"),$e->getMessage());
                //return json(['status'=>config("status.error"),'msg'=>$e->getMessage()]);
            }
            //判断是否为true否则弹出错误
            if($result){
                return show(config("status.success"),"登录成功");
                //return json(['status'=>config("status.success"),'msg'=>"登录成功"]);
            }
            return show(config('status.error'),$AdminUserObj->getError());
            //return json(['status'=>config("status.error"),'msg'=>$AdminUserObj->getError()]);
        }

        //继承文件方法会有点问题
        /*public function initialize(){
            //初始化
            if($this->isLogin()){
                echo "已经登录";

                return $this->redirect(url("index/index"));
            }
            echo "没有登录";
        }*/

        public function md5(){
            //session(config('admin.session_admin'),'张三');
            //halt(session(config('admin.session_admin')));
            echo md5('admin');
        }

        public function sms(){
            echo 1;
            //$smsYtx = new Ytx();
           //sendTemplateSMS('19974233942',array('928388',1),1);
        }
    }
?>

<?php 
    namespace app\admin\controller;
    use think\facade\View;
    //use think\captcha\facade\Captcha;
    use app\admin\controller\BaseAdmin;
    use app\common\model\mysql\AdminUser;
    class Login extends BaseAdmin{
        
        public function index()
        {
            return View::fetch('login/index');
        }
        
        //登入验证
        public function check(){
            if(!$this->request->isPost()){
                return json(['status'=>config("status.error"),'msg'=>"请求错误"]);
            }
            //param第一个参数为传来的name名,二为不知道,3为过滤
            $username = $this->request->param("username","","trim");
            $password = $this->request->param("password","","trim");
            $captcha = $this->request->param("captcha","","trim");
            if(empty($username) || empty($password) || empty($captcha)){
                return json(['status'=>config("status.error"),'msg'=>" 参数错误"]);
            }
            
            //把app目录下面的middleware.php文件的Session初始化\think\middleware\SessionInit::class打开
            
            /*if(!captcha_check($captcha)){
                return json(['status'=>config("status.error"),'msg'=>"$captcha"]);
            }*/
           try {
                $obj=new AdminUser();
                $result=$obj->getAdmin_User($username);
                if(empty($result)||$result->status!=config('status.mysql.table_normal')){
                    return json(['status'=>config("status.error"),'msg'=>"用户不存在"]);
                }
                $res=$result->toArray();
                //判断密码是否正确
                if($res['password'] != md5($password)){
                    return json(['status'=>config("status.error"),'msg'=>"密码错误"]);
                }
                
                $id=$res['id'];
                $data=[
                    'update_time'=>time(),
                    'last_login_time'=>time(),
                    'last_login_ip'=>request()->ip()
                ];
                //更新数据库数据
                $update=$obj->updateById($id,$data);
                if(empty($update)){
                    return json(['status'=>config("status.error"),'msg'=>"登录失败"]);
                }
           } catch (\Exception $e){
               return json(['status'=>config("status.error"),'msg'=>"内部错误登录失败"]);
           }
           session(config('admin.session_admin'),$res);
            return json(['status'=>config("status.success"),'msg'=>"登录成功"]);
            //return json(['status'=>config("status.error"),'msg'=>"登录失败"]);
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
            halt(session(config('admin.session_admin')));
            echo md5(123456);
        }
        
        public function test(){
            $obj=new AdminUser();
            $result=$obj->getAdmin_User('admin');
            dd($result);
        }
    }
?>
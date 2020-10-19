<?php
    namespace app\admin\controller;
    use app\BaseController;
    //use \liliuwei\think\Jump;
    use think\exception\HttpResponseException;
    class BaseAdmin extends BaseController{
        //use Jump;
        public $adminUser = null;
        //继承文件方法会有点问题
        /*public function initialize(){
            //初始化
            parent::initialize();
            if(empty($this->isLogin())){
                echo 1;
                return $this->redirect(url('login/index'),302);
            }
        }*/

        public function isLogin(){
            $this->adminUser = session(config('admin.session_admin'));
            if(empty($this->adminUser)){
                return false;
            }
            return true;
        }

        //不做这个会报错
        public function redirect(...$args)
        {
            // 此处 throw new HttpResponseException 这个异常一定要写
            throw new HttpResponseException(redirect(...$args));
        }

    }
?>

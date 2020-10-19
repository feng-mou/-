<?php
    namespace app\admin\controller;
    use app\admin\controller\BaseAdmin;

    class Loginout extends BaseAdmin
    {
        //退出登录
        public function index(){
            //清除session
            session(config('admin.session_admin'),null);
            //跳转地址
            return $this->redirect(url('login/index'));
        }
    }
?>

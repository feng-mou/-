<?php 
    namespace app\admin\controller;
    use app\admin\controller\BaseAdmin;
                
    class Loginout extends BaseAdmin
    {
        //�˳���¼�߼�
        public function index(){
            //���session
            session(config('admin.session_admin'),null);
            //��ת��¼
            return $this->redirect(url('login/index'));
        }
    }
?>
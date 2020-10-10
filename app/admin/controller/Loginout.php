<?php 
    namespace app\admin\controller;
    use app\admin\controller\BaseAdmin;
                
    class Loginout extends BaseAdmin
    {
        //ÍË³öµÇÂ¼Âß¼­
        public function index(){
            //Çå³ýsession
            session(config('admin.session_admin'),null);
            //Ìø×ªµÇÂ¼
            return $this->redirect(url('login/index'));
        }
    }
?>
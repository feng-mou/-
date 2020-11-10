<?php
    namespace app\admin\controller;
    use think\facade\View;
    use app\admin\controller\BaseAdmin;
    class Index extends BaseAdmin{

        //渲染index页面
        public function index()
        {
            //echo 1;
            return View::fetch('index/index');
            //return redirect('https://www.baidu.com')->send();

        }

        public function welcome(){
            return View::fetch('index/welcome');
            //return $this->redirect(url("index/index"));
            //return redirect('index/welcome');
        }
    }
?>

<?php 
    namespace app\admin\controller;
    use think\captcha\facade\Captcha;
    use app\BaseController;
    class Verify{
        public function index()
        {
            return Captcha::create();
        }
    }
?>
<?php 
    namespace app\demo\controller;
    use app\BaseController;
    class Check extends BaseController
    {
        public function index()
        {
            dump($this->request->type);
        }
        
        public function test(){
            dump($this->request->type);
        }
    }
    
?>
<?php
    namespace app\admin\controller;
    use app\BaseController;
    use app\common\business\Category;
    use app\common\lib\Status;
    use think\facade\Log;
    class Test extends BaseController{
//        public $ddObj=null;
//        public function __construct()
//        {
//            $this->ddObj = new \app\common\business\Category();
//        }

        public function page_test(){
            $obj = new Category();
            $data = [
                'pid'=>0
            ];
            $result = $obj->getList($data,5);
            dd($result);
            //dd($this->categoryObj->find(112));
        }

        public function status_test(){
            $result = Status::getStatus();
            //dd($result);
            $a=array("Volvo","XC90",array("BMW","Toyota"));
            $reverse=array_reverse($a);

            $preserve=$a;

            print_r($a);
            echo "<br/>";
            print_r($reverse);
            echo "<br/>";
            print_r($preserve);
            Log::record('错误信息');
            //如果希望从主库读取，可以使用
            //Db::query("select * from think_user where status=:id", ['id' => 1], true);
//            //传入错误日志信息
//            set_journal();
        }
    }

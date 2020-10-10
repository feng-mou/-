<?php 
    //数据库测试
    namespace app\demo\controller;
    use app\BaseController;
    use think\facade\Db;    
    use app\demo\model\User;
    class Data extends BaseController{
        //查
        public function index()
        {
            //通过门面模式来获取
            //$result=Db::table("tp6_test")->where('id',1)->find();
            
            //通过容器的方式来处理
            //app()容器
            //$result=app('db')->table("tp6_test")->where('id',1)->find();
            
            //排序
            /*$result=Db::table("tp6_test")
                        ->order('id','desc')
                        ->limit(0,2)
                        ->select();*/
            
            //tp6提供的page()函数参数1为第几页,参数2为几条数据
            $result = Db::table('tp6_test')
                        ->where('id',">",0)
                        ->where('time',2002)
                        ->page(1,2)
                        ->select();
            dump($result);
        }
        
        public function abc()
        {
            //随便了
            //$result=Db::table("tp6_test")->where('id',10)->find();
            
            //输出sql语句
            $result=Db::table("tp6_test")->where('id',10)->fetchSql()->find();
            dump($result);
        }
        
        //增加数据
        public function demo()
        {
            $data=[
                'user'=>'yy',
                'pass'=>1314,
                'title'=>'天下',
                'time'=>'2009'
            ];
            //新增逻辑
            //$res=Db::table('tp6_test')->insertGetId($data);
            
            //删除逻辑
            //$res=Db::table('tp6_test')->where('id',3)->delete();
            
            //更新数据
            $res=Db::table('tp6_test')->where('id',5)->update(['user'=>'美丽的小姐']);
            dd($res);
        }

        //model模型
        public function cha(){
            //find参数为id
            $result=Demo::find(9);
            
            //使用toAarray()获得想要的数组样式
            //dump($result->toAarray());
            
            dd($result);
        }  
        
        //对象吗?
       public function demo2()
       {
           /*$modelObj = new Demo();
           $result = $modelObj->where('id','>','4')
                    ->limit(3)
                    ->order('id',"desc")
                    ->select();
           //dd($result);
           foreach($result as $sm=>$ak){
               dump("user为".$ak['user']."---id为".$ak['id']);
               dump($result->getStatusAttr());
           }*/
       }
       
       public function hello(){
           return time();
       }
       
       //测试model
       public function model1(){
           //id为1的数据
           $obj = User::find(1);
           dump($obj->toArray());
       }
       
       //状态
       public function model2(){
           $obj =new User();
           $result = $obj
                    ->where('category_id',1)
                    ->select();
           dd($result->toArray());
           foreach($result as $key)
           {
               dump($key['content']);
           }
       }
       
       //获取什么鬼对象
       
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    }
?>
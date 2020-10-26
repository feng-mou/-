<?php
    namespace app\common\business;
    class Category{
        //用来指定公共模型的
        public $categoryObj = null;
        public function __construct()
        {
            $this->categoryObj=new \app\common\model\mysql\Category;
        }
        public function add($data){
            //用父类的save方法加数据
            $data['status']=config('status.mysql.table_normal');
            $name = $data['name'];
            $pid = $data['pid'];
            $res = $this->categoryObj->getCategory($name, $pid);
            if($res){
                throw new \think\Exception("该分类下分类名已存在,换个名字试试");
            }
//            try {
//                $res = $this->categoryObj->getCategory($name, $pid);
//            }catch(\Exception $e){
//                throw new \think\Exception("该分类下分类名已存在,换个名字试试");
//            }

            try{
                $this->categoryObj->save($data);
            }catch(\Exception $e){
                throw new \think\Exception("数据库内部异常");
            }
            return $this->categoryObj->getLastInsID();
        }
    }

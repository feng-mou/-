<?php
    namespace app\common\business;
    //引入Db门面模式
    use think\Exception;
    use think\facade\Db;
    use think\facade\Log;
    class Category{
        //用来指定公共模型的
        public $categoryObj = null;
        public function __construct()
        {
            $this->categoryObj=new \app\common\model\mysql\Category;
        }

        /**
         * 获取分类全部数据
         * 2020.10.26 19:30:00
         * @return array|\think\Collection
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\DbException
         * @throws \think\db\exception\ModelNotFoundException
         */
        public function getCategorys(){
            //$result这是一个对象
            $field = "id , name ,pid";
            $result = $this->categoryObj->getCategoryResult($field);
            if(empty($result)){
                return $result;
            }
            return $result->toArray();
        }

        /**
         * 无限级分类
         * @return array|\think\Collection
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\DbException
         * @throws \think\db\exception\ModelNotFoundException
         */
        public function cnm(){
            $field = "id as category_id, name ,pid";
            $result = $this->categoryObj->getCnm($field);
            if(empty($result)){
                return $result;
            }
            return $result->toArray();
        }

        /**
         * 添加商品分类
         * @param $data
         * @return mixed
         * @throws Exception
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\DbException
         * @throws \think\db\exception\ModelNotFoundException
         */
        public function add($data){
            //用父类的save方法加数据
            $data['status']=config('status.mysql.table_normal');
            $name = $data['name'];
            $pid = $data['pid'];

            $res = $this->categoryObj->getCategory($name, $pid);
            if($res){
                throw new \think\Exception("该分类下分类名已存在,换个名字试试");
            }

            try{
                $this->categoryObj->save($data);
            }catch(\Exception $e){
                throw new \think\Exception("数据库内部异常");
            }
            return $this->categoryObj->getLastInsID();
        }

        /**
         * 根据id=pid查询有多少数据
         * @param $data pid
         * @param $num  数量
         * @return array
         * @throws \think\db\exception\DbException
         */
        public function getList($data,$num)
        {
            $list = $this->categoryObj->getLastS($data,$num);
            $result = $list->toArray();
            //获取有多少子栏目
            $arrayPids = array_column($result['data'],'id');
            //dump($arrayPids);
            $pids = implode(",", $arrayPids);
            if($pids){
                $acg = $this->categoryObj->getChildCount(['pid'=>$pids]);
                //循环把pidCounts加入字段
                $ziPiss = [];
                foreach($acg as $key){
                    //$kye下面的pid对应多少条数据
                    $ziPiss[$key['pid']] = $key['count'];
                }
                //return $ziPiss;
                //var_dump($result['data']);
                if($result['data']){
                    foreach($result['data'] as $key=>$value){
                        //这个数据儿子有多少个加进去
                        $result['data'][$key]['erZis'] = $ziPiss[$value['id']]??0;
                    }
                    return $result;
                }
            }
        }

        /**
         * 修改排序业务逻辑
         * @param $id
         * @param $listorder
         * @return bool
         * @throws \think\Exception
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\DbException
         * @throws \think\db\exception\ModelNotFoundException
         */
        public function listEdit($id,$listorder)
        {
            if(empty($id) || empty($listorder)){
                throw new \think\Exception("参数错误");
            }

            $res = $this->categoryObj->find($id);
            if(!$res){
                throw new \think\Exception("不存在这个上级");
            }
            $result = $this->categoryObj->get_listEdit($id,$listorder);
            if($result){
                return true;
            }else{
                throw new \think\Exception("更新失败");
            }
        }

        public function statusC($id,$status){
            //获取有没有这个人
            $res = $this->categoryObj->find($id);
            if(empty($res)){
                throw new \think\Exception("没这个人");
            }
            if($res['status']==$status){
                throw new \think\Exception("你根本就没有修改状态");
            }
            try{
                $result =  $this->categoryObj->UserEditStatus($id,$status);
            }catch(\Exception $e){
                throw new \think\Exception("数据库内部异常");
            }
            return true;

        }

        /**
         * 修改为删除状态
         * @param $id
         * @param $status
         */
        public function userEditStatus($id,$status){
            //获取有没有这个人
            $res = $this->categoryObj->find($id);
            if(empty($res)){
                throw new \think\Exception("没这个人");
            }
            try{
                $result =  $this->categoryObj->UserEditStatus($id,$status);
            }catch(\Exception $e){
                throw new \think\Exception("数据库内部异常");
            }
            return true;
        }


        /**
         * 查询分类
         * @param int $id 分类id
         * @return array|bool
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\DbException
         * @throws \think\db\exception\ModelNotFoundException
         */
        public function getBreadCrumb($id) {
            try {
                $res = $this->categoryObj->getIdResultFind($id);
            } catch (\Exception $e) {
                // 记录日志
                Log::record($e->getMessage());
                return false;
            }
            if (!$res) {
                return [];
            }
            $res = $res->toArray();
            // 将获取的指定id的数据放入数组中
            $tree[] = $res;
            // 如果当前的pid > 0，则说明不是顶级分类
            while ($res['pid'] > 0) {
                // 继续查询该pid下的分类，直到退出循环
                $res = $this->categoryObj->getIdResultFind($res['pid']);
                $res = $res->toArray();
                $tree[] = $res;
            }
            // 翻转数据
            return array_reverse($tree);
            //return $tree;
        }

        public function getRes($id){
            $result = $this->categoryObj->find($id);
            if(!$result){
                return [];
            }

            return $result->toArray();
        }

        public function xiuGai($id,$name){
            if(mb_strlen($name,'UTF-8')>17){
                return false;
            }
            $update = [
                'name'=>$name
            ];
            $result = $this->categoryObj->where('id','=',"$id")->save($update);
            return true;
        }

        /**
         * 获取pid数据
         * @param $id
         * @param string $field
         */
        public function getPidS($id,$field='id,name,pid'){
           try{
                $res = $this->categoryObj->getResult($id,$field);
           }catch (\Exception $e){
               $res = [];
           }
           $result = $res->toArray();
           return $result;
        }

        public function getPidErZi($id,$field='id,name,pid'){
            try{
                $res = $this->categoryObj->getResult($id,$field);
            }catch (\Exception $e){
                $res = [];
            }
            $result = $res->toArray();
            return $result;
        }
    }

<?php
    namespace app\common\model\mysql;
    use think\Model;
    class Goods extends Model{
        protected $name="goods";
        /**
         * 自动写入更新时间,字段必须为指定的
         * @var bool
         */
        protected $autoWriteTimestamp = true;
        /**
         * 插入数据
         * @param $data
         * @return bool
         */
        public function add($data){
            $result = $this->save($data);
            return $result;
        }

        /**
         * 根据传来的goods_id更新goods表数据
         * @param $goods_id
         * @param $goodsUpdateData
         * @return bool
         */
        public function updateById($goods_id,$goodsUpdateData){
            $goodsUpdateData['update_time'] = time();
            $where = [
                'id'=>$goods_id
            ];
            return $this->where($where)->save($goodsUpdateData);
        }

        public function getLastS($title,$timeStart,$timeEnd,$num){

            $sqlWhere = null;
            if(!empty($title) && !empty($timeStart) && !empty($timeEnd)){
                $sqlWhere = "create_time >=$timeStart and create_time<=$timeEnd and title like'%$title%'";
            }
            if(!empty($title) && empty($timeStart) && empty($timeEnd)){
                $sqlWhere = "title like'%$title%'";
            }
            if(empty($title) && !empty($timeStart) && !empty($timeEnd)){
                $sqlWhere = "create_time >=$timeStart and create_time<=$timeEnd";
            }
            $order = [
                'listorder'=>"desc",
                'id'=>"desc"
            ];
            //tp6提供的paginate()分页函数
            $result = $this->where("status","<>",config('status.mysql.table_delete'))
                ->where($sqlWhere)
                ->order($order)
                ->paginate($num);
            //echo $this->getLastSql();
            return $result;
        }

        /**
         * 根据修改goods表的status状态
         * @param $id
         * @return bool
         */
        public function updateGoodsStatus($id){
            $where = [
                'id'=>$id
            ];
            $update = [
                'status'=>99
            ];
            return $this->where($where)->save($update);
        }

        /**
         * 修改goods表的status状态
         * @param $id
         * @param $status
         * @return bool
         */
        public function updateStatus($id,$status){
            $where = [
                'id'=>$id
            ];

            $update = [
                'status'=>$status
            ];
            $res = $this->where($where)->save($update);
            return $res;
        }

        /**
         * 根据id修改goods表is_index_recommend的状态
         * @param $id
         * @param $status
         * @return bool
         */
        public function is_index_recommend_status($id,$status){
            $where = [
                'id'=>$id
            ];

            $update = [
                'is_index_recommend'=>$status
            ];
            $res = $this->where($where)->save($update);
            return $res;
        }

        /**
         * 修改排序
         * @param $id
         * @param $listorder
         * @return bool
         */
        public function updateListorderStatus($id,$listorder){
            $where = [
                'id'=>$id
            ];

            $update = [
                'listorder'=>$listorder
            ];
            $res = $this->where($where)->save($update);
            return $res;
        }

        /**
         * 获取首页推荐轮播图
         * @param $where
         * @param $limit
         * @return \think\Collection
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\DbException
         * @throws \think\db\exception\ModelNotFoundException
         */
        public function getRotation($where,$limit,$field){
            $order = [
                'listorder'=>'desc',
                'id'=>'desc'
            ];
            $result = $this->field($field)->where($where)->limit($limit)->order($order)->select();
            return $result;
        }

        /**
         * @param $value 图片路径
         * @return string
         */
        public function getImageAttr($value){
            return 'http://tp6.cc/'.$value;
            //return request()->domain().$value;
        }

    }

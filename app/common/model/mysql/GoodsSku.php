<?php
    namespace app\common\model\mysql;
    use think\Model;

    class GoodsSku extends Model{

        protected $name = "goods_sku";
        /**
         * 自动写入更新时间,字段必须为指定的
         * @var bool
         */
        protected $autoWriteTimestamp = true;
        /**
         * 根据id对应goods_id修改goods_sku表数据
         * @param $id
         */
        public function updateGoodsStatus($id){
            $where = [
                'goods_id'=>$id
            ];
            $update = [
                'status'=>99
            ];
            $this->where($where)->update($update);
        }
    }

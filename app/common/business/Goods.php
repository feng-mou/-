<?php
namespace app\common\business;
use app\common\business\GoodsSku;
use app\common\model\mysql\GoodsSku as GoodsSkuModel;
class Goods{
    public $model = null;
    public function __construct()
    {
        $this->model = new \app\common\model\mysql\Goods;
    }

    /**
     * 查所有数据并分页
     * @param $data
     * @param $num
     * @param $time 时间数组
     * @param $title 标题
     * @return array
     */
    public function getList($data,$num){
        $timeStart = "";
        $timeEnd = "";
        $title = "";
        if(!empty($data['time'])){
            $timeStart = strtotime($data['time'][0]);
            $timeEnd = strtotime($data['time'][1]);
        }
        if(!empty($data['title'])){
            $title = $data['title'];
        }
        $result = $this->model->getLastS($title,$timeStart,$timeEnd,$num);
        return $result->toArray();
    }


    public function insertData($data){
        // 启动事务
        //$this->model->startTrans();
        try {
            //插入数据并获取id给下面的逻辑用
            $result = $this->model->save($data);
            if (!$result) {
                throw new \Exception("数据插入失败");
            }
            $goods_id = $this->model->id;
            //dump($goods_id);
            if ($data['goods_specs_type'] == '1') {
                //统一规格
            } elseif ($data['goods_specs_type'] == '2') {
                //多规格重点
                //使用business层的方法处理规格属性
                $data['goods_id'] = $goods_id;
                $goodsSkuObj = new GoodsSku();
                $res = $goodsSkuObj->saveAll($data);
                //dump($res);

                //更新goods表
                if (empty(!$res)) {
//                    //错误场景
//                    $res="";
                    //总库存
                    $stock = array_sum(array_column($res, 'stock'));
                    //return $stock;
                    $goodsUpdateData = [
                        //现价
                        'price' => $res[0]['price'],
                        //原价
                        'cost_price' => $res[0]['cost_price'],
                        //总库存
                        'stock' => $stock,
                        //商品默认的sku_id
                        'sku_id' => $res[0]['id'],
                    ];
                    $goodsRes = $this->model->updateById($goods_id, $goodsUpdateData);
                    if (!$goodsRes) {
                        throw new \Exception("插入:goodsUpdateData失败");
                    }
                    return true;
                }
            }
            //提交事务
            //$this->model->commit();
            return true;
        }catch (\think\Exception $e){
            //记录错误日志
            // 回滚事务
            //$this->model->rollback();
            //exit;
            return false;
        }
        return true;
    }

    public function delGoodsGoods_skuStatus($id){
        $id = intval($id);
        // 启动事务
        $this->model->startTrans();
        try{
            //根据id对应的goods_id修改goods_sku表的状态为删除
            $goodsSkuObjModel = new GoodsSkuModel();
            $goodsSkuObjModel->updateGoodsStatus($id);
            //根据id对应的id修改goods表的状态为删除
            $this->model->updateGoodsStatus($id);
            //提交事务
            $this->model->commit();
        }catch (\Exception $e){
            //回滚事务
            $this->model->rollback();
        }
        return true;
    }

    /**
     * 修改status状态
     * @param $id
     * @param $status
     * @return bool
     * @throws \Exception
     */
    public function updateStatus($id,$status){
        $res = $this->model->updateStatus($id,$status);
        if(!$res){
            throw new \Exception("修改失败");
        }
        return true;
    }

    /**
     * 修改推荐状态业务逻辑层
     * @param $id
     * @param $status
     * @return bool
     * @throws \Exception
     */
    public function is_index_recommend_status($id,$status){
        $res = $this->model->is_index_recommend_status($id,$status);
        if(!$res){
            throw new \Exception("修改失败");
        }
        return true;
    }

    public function updateListorder($id,$listorder){
        $res = $this->model->updateListorderStatus($id,$listorder);
        if(!$res){
            throw new \Exception("修改失败");
        }
        return true;
    }
}
?>

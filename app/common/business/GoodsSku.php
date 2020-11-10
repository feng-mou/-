<?php
namespace app\common\business;

use think\Exception;

class GoodsSku{
    public $model = null;
    public function __construct()
    {
        $this->model = new \app\common\model\mysql\GoodsSku;
    }

    /**
     * 处理规格逻辑
     * @param $data
     * @return array|bool
     * @throws Exception
     */
    public function saveAll($data){
        if(!$data['skus']){
            return false;
        }

        //循环skus数组拿有用的数据插入进去,记得加goods_id,用来查对应哪张表
        foreach($data['skus'] as $key){
            $insertData[] = [
                "goods_id" => $data['goods_id'],
                'specs_value_ids' => $key['propvalnames']['propvalids'],
                'price' => $key['propvalnames']['skuSellPrice'],
                'cost_price' => $key['propvalnames']['skuMarketPrice'],
                'stock'=>$key['propvalnames']['skuStock'],
            ];
        }

        try{
            //批量插入
            $result = $this->model->saveAll($insertData);
            //dd($result->toArray());
            return $result->toArray();
        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
        return true;
    }
}
?>

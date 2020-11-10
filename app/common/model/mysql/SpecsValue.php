<?php
namespace app\common\model\mysql;
use think\Model;

class SpecsValue extends Model
{

    protected  $name = 'specs_value';
    /**
     * 自动写入更新时间,字段必须为指定的
     * @status 状态
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    public function getSpecsResult($specs_id,$status){
        $where = [
            'status'=>$status,
            'specs_id'=>$specs_id
        ];
        $result = $this->where($where)->select();
        return $result;
    }

    /**
     * 查询是否有这个规格属性
     * @param $specs_id
     * @param $name
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getSpecs($specs_id,$name){
        $where = [
            'specs_id'=>$specs_id,
            'name'=>$name
        ];
        $result = $this->where($where)->find();
        if(!$result){
            return false;
        }
        return true;
    }
    /**
     * 向specs_value表插入规格属性
     * @param $specs_id
     * @param $name
     * @return bool
     */
    public function specsAddShuXin($specs_id,$name){
        $data = [
            'specs_id'=>$specs_id,
            'name'=>$name,
            'status'=>1
        ];
        $result = $this->save($data);
        return $result;
    }
}



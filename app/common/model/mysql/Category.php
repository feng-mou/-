<?php
namespace app\common\model\mysql;
use think\Model;

class Category extends Model
{

    protected  $name = 'category';
    /**
     * 自动写入更新时间,字段必须为指定的
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    /**
     * 查询这个pid下是否有这数据 有返回true不能添加,否则可以添加
     * @param $name
     * @param $pid
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategory($name,$pid){
//        if(empty($name) || empty($pid)){
//            return true;
//        }
        $where = [
            'pid'=>$pid,
            'name'=>$name
        ];
        $result = $this->where($where)->find();
        if($result){
            return true;
        }
        return false;
    }
}



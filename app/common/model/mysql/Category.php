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

    /**
     * 查询 mall_category表里面的所有数据
     * @param string $field 要查询的字段
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryResult($field = "*"){
        $where = [
            'status'=>config('status.mysql.table_normal')
        ];
        $order = [
            'listorder'=>"desc",
            'id'=>"desc"
        ];
        $result = $this->where($where)->order($order)->field($field)->select();
        return $result;
    }

    /**
     * 无限级分类
     * @param string $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCnm($field = "*"){
        $where = [
            'status'=>config('status.mysql.table_normal')
        ];
        $order = [
            'listorder'=>"desc",
            'id'=>"desc"
        ];
        $result = $this->where($where)->order($order)->field($field)->select();
        return $result;
    }

    /**
     * 查询index
     * @param $data
     * @param $num
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function getLastS($data,$num){

        $order = [
            'listorder'=>"desc",
            'id'=>"desc"
        ];

        //tp6提供的paginate()分页函数
        $result = $this->where("status","<>",config('status.mysql.table_delete'))
            ->where($data)
            ->order($order)
            ->paginate($num);
        //echo $this->getLastSql();
        return $result;
    }

    /**
     * 更新排序和时间
     * @param $id
     * @param $listorder
     * @return bool
     */
    public function get_listEdit($id,$listorder){
        $where = [
            'id'=>$id,
        ];
        $update = [
            'listorder'=>$listorder,
            'update_time'=>time(),
        ];
        return $this->where($where)->save($update);
    }

    public function UserEditStatus($id,$status){
        $where = [
            'id'=>$id,
        ];
        $update = [
            'status'=>$status,
            'update_time'=>time(),
        ];
        return $this->where($where)->save($update);
    }

    /**
     * 查询指定分类id，名称，和父级（pid）信息
     * @param $id 分类id
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getIdResultFind($id){
        $id = intval($id);
        if(!$id){
            return false;
        }
        return $this->field('id,name,pid')->where('id','=',$id)->find();
    }

    /**
     * @param $pid
     * @param $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getResult($pid,$field){
        $pid = intval($pid);
        $where = [
            'pid'=>$pid,
        ];
        $order = [
            'listorder'=>"desc",
            'id'=>"desc"
        ];
        $result = $this->field($field)->where($where)->order($order)->select();
        return $result;
    }

    public function getChildCount($pids){
        $where[] = ['pid',"in",$pids['pid']];
        $where[] = ["status","<>",config("status.mysql.table_delete")];
        $res = $this->where($where)
            ->field(['pid',"count(*) as count"])
            ->group("pid")
            ->select();
        return $res;
    }
}



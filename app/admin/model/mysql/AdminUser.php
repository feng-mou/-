<?php
namespace app\admin\model\mysql;
use think\Model;

class AdminUser extends Model
{

    protected  $name = 'admin_user';

    /**
     * 根据name更新mall_admin_user表里的数据
     * @time 2020.9.5
     * @param $user
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdmin_User($username){
        if(empty($username)){
            return false;
        }
        $where = [
            'username'=>trim($username)
        ];
        $result=$this->where('username',$username)->find();
        return $result;
    }

    /**
     * 根据id更新admin_user数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id,$data){
        //转int类型
        $id=intval($id);
        if(empty($id) || empty($data) || !is_array($data)){
            return false;
        }

        $where = [
            'id'=>$id
        ];
        //更新数据并返回结果,save方法先查是否有这数据有就更新,没有就插入
        return $this->where($where)->save($data);
    }
}
?>

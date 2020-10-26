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

    //更新数据
    public function updateById($id,$data){
        $id=intval($id);
        if(empty($id) || empty($data) || !is_array($data)){
            return false;
        }

        $where = [
            'id'=>$id
        ];
        return $this->where($where)->save($data);
    }
}
?>

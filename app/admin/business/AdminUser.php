<?php
namespace app\admin\business;
//use app\admin\controller\BaseAdmin;
//use app\admin\model\mysql\AdminUser as AdminUserS;
class AdminUser{

    //因为用到了model可以先实例化然后其他方法也可以调用
    public $obj = null;
    public function __construct()
    {
        $this->obj = new \app\admin\model\mysql\AdminUser();
    }
    public function login($data)
    {
        //$obj=new \app\admin\model\mysql\AdminUser();
        $res=$this->getAdminUser($data['username']);
        //不存在场景
        if(!$res)
        {
            //抛出错误异常
            throw new \think\Exception("用户不存在");
        }
        /*if(empty($result)||$result->status!=config('status.mysql.table_normal')){
            //抛出错误异常
            throw new \think\Exception("用户不存在");
        }*/
        //判断密码是否正确
        if($res['password'] != md5($data['password']))
        {
            //抛出错误异常
            throw new \think\Exception("密码错误");
        }

        $id=$res['id'];
        $data2=[
            'update_time'=>time(),
            'last_login_time'=>time(),
            'last_login_ip'=>request()->ip()
        ];
        //更新数据库数据,更新时间
        $update=$this->obj->updateById($id,$data2);
        if(empty($update))
        {
            //抛出错误异常
            throw new \think\Exception("登录失败");
        }
        session(config('admin.session_admin'),$res);
        return true;
    }
    //获取干净的数组
    public function getAdminUser($username){
        $result=$this->obj->getAdmin_User($username);
        if(empty($result)||$result->status!=config('status.mysql.table_normal'))
        {
            return false;
        }
        $res=$result->toArray();
        return $res;
    }
}
?>

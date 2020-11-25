<?php
    namespace app\common\model\mysql;
    use think\Model;

    class User extends Model
    {

        protected  $name = 'user';
        /**
         * 自动写入更新时间,字段必须为指定的
         * @var bool
         */
        protected $autoWriteTimestamp = true;
        public function getUser($phoneNumber){
            if(empty($phoneNumber)){
                //return json(['status'=>config('status.error'),'msg'=>"参数错误"]);
                return false;
            }
            $where = [
                'phone_number'=>$phoneNumber
            ];
            $result=$this->where('phone_number',$phoneNumber)->find();
            return $result;
        }

        //更新mall_user表数据数据
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

        //根据id获取mall_user用户表数据
        public function getUserResult($id){
            if(empty($id)){
                return false;
            }
            return $this->find($id);
        }

        //更新性别
        public function get_username_sex($id,$sex){
            $update = [
                'sex'=>$sex
            ];
            $result = $this->where('id','=',$id)->update($update);
            if($result){
                return true;
            }else{
                return false;
            }
        }

        //获取用户数据
        public function get_username($username){
            if(empty($username)){
                return false;
            }
            $where = [
                'username'=>$username
            ];
            $result = $this->where($where)->find();
            return $result;

        }

        //根据id修改mall_user表用户信息
        public function update_user($id,$data)
        {
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

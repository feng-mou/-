<?php 
    namespace app\common\model\mysql;
    use think\Model;
    
    class AdminUser extends Model
    {
        
        protected  $name = 'admin_user';
        
        public function getAdmin_User($user){
            if(empty($user)){
                //return json(['status'=>config('status.error'),'msg'=>"��������"]);
                return false;
            }
            $where = [
                'username'=>trim($user)
            ];
            $result=$this->where('username',$user)->find();
            return $result;
        }
        
        //��������
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
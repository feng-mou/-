<?php
    namespace app\common\business;
    use app\common\lib\Str;
    use app\common\lib\Login_token_time;

    class User{

        //用来指定公共模型的
        public $userObj = null;
        public function __construct()
        {
            $this->userObj=new \app\common\model\mysql\User;
        }

        //登录业务逻辑
        public function login($data){
            //判断redis的这个手机号是否有值
            $redisCode = cache(config('redis_name.phone').$data['phone_number']);
            if(empty($redisCode) || $redisCode!=$data['code']){
                throw new \think\Exception("验证码不正确");
            }

            //查数据库user表是否有这手机号手机,有就进入下一步更新时间,否则新增一条数据
            //取出数据来更新
            $res = $this->userObj->getUser($data['phone_number']);
            if(!$res)
            {
                $username = 'cpdd_'.$data['phone_number'];
                $data = [
                    'username'=>$username,
                    'phone_number'=>$data['phone_number'],
                    'type'=>$data['type'],
                    'status'=>config('status.mysql.table_normal')
                ];

                //获取id
                try {
                    //加入数据
                    $this->userObj->save($data);
                    $userId = $this->userObj->id;
                    //throw new \think\Exception("$userId");
                } catch( \Exception $e) {
                    throw new \think\Exception("数据库内部异常");
                }
                //throw new \think\Exception("数据新增成功");

            }else{
                //更新数据
                $dd = [
                    'type'=>$data['type']
                ];
                $res->save($dd);
                $userId = $res->id;
                $username = $res->username;
            }
            $redisData = [
                'id'=>$userId,
                'username'=>$username,
                'sex'=>0
            ];

            //加密
            $token = Str::loginToken($data['phone_number']);
            //放入redis
            $result = cache(config('redis_name.login_token').$token,json_encode($redisData,true),Login_token_time::getLoginTokenTime($data['type']));
            return $result ? ["token"=>$token,"username"=>$username] : false;
            //throw new \think\Exception("登录成功");
        }

        //获取个人信息
        public function getUser($id){
            //返回的结果
            $results = $this->userObj->getUserResult($id);
            if(!$results){
                return [];
            }
            return $results->toArray();
        }

        //修改个人信息
        public function update_user($id,$data){
            if(empty($id) || empty($data) || !is_array($data)){
                throw new \think\Exception("参数错误");
            }
            $usernameResult = $this->userObj->get_username($data['username']);
            if($usernameResult){
                throw new \think\Exception("用户名已存在");
            }
            return $this->userObj->update_user($id,$data);
        }
    }

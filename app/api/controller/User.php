<?php
    namespace app\api\controller;
    //user表
    use app\common\business\User as UserBis;
    use app\common\lib\Login_token_time;
    //因为在同级目录不用引入就可以继承了
    class User extends AuthBase
    {

        /**
         * 登录成功后的个人信息页面
         * @time 2020.9.10
         * @return \think\response\Json
         */
        //public $sex = "";
        public function index()
        {
            //echo "登录成功";
            $result = (new UserBis())->getUser($this->UserId);
            $resultUser = [
                'id'=>$result['id'],
                'username'=>$result['username'],
                'sex'=>$result['sex']
            ];

            return show(config('status.success'),"OK",$resultUser);
        }


        /**
         * 修改执行的方法
         * @time 2020.9.10
         * @return \think\response\Json
         */
        public function update(){
            //echo "无聊";
            $username = input('param.username',"","trim");
            $sex = input("param.sex",0,"intval");
            $data = [
                'username'=>$username,
                'sex'=>$sex
            ];
            //return show(config('status.error'),"$sex");
            //判断参数是否正确
            try {
                validate(\app\api\validate\User::class)->scene('update_user')->check($data);
            }catch( \think\Exception\ValidateException $e){
                return show(config('status.error'),$e->getError());
            }

            $redisRes=cache(config('redis_name.login_token').$this->accessToken);
            $result = json_decode($redisRes,true);
            if($username == $result['username']){
                //return show(config('status.error'),"名字一样");
                //更新性别
                try{
                    $obj = new UserBis();
                    $yy = $obj->update_user_sex($this->UserId,$sex);
                }catch( \Exception $e){
                    return show(config('status.error'),$e->getMessage());
                }
                return  show(config('status.success'),"更新性别成功");
            }

            //更新性别加名字
            try{
                $obj = new UserBis();
                $result = $obj->update_user($this->UserId,$data);
            }catch( \Exception $e){
                return show(config('status.error'),$e->getMessage());
            }
            //$userInfo = cache(config('redis_name.login_token').$this->accessToken,json_encode($data,true),Login_token_time::getLoginTokenTime(1));
            return  show(config('status.success'),"更新数据成功");
        }

        //测试redis
        public function test(){
            $result=cache(config('redis_name.login_token').$this->accessToken);
            echo Login_token_time::getLoginTokenTime(1);
            $test = json_decode($result,true);
            dump($test);
            echo "<br/>";
            dump($test['id']);
            echo "<br/>";
            dump($this->UserId);
        }
    }

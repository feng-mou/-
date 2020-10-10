<?php
    //强制类型声明
    declare (strict_types = 1);
    namespace app\admin\middleware;
    class Auth
    {
        //handle必写,$request
        public function handle($request, \Closure $next)
        {
            //前置中间件,无法获取控制器和方法
            //判断session是否存在,是否是Login控制器下面的
            //dump($request->pathinfo());
            //判断session没值的时候必须是login方法下的
            if(empty(session(config('admin.session_admin'))) && !preg_match("/login/", $request->pathinfo()))
            {
                 return redirect((string) url('login/index'));
            }
            return $next($request);
            //$acg=$next($request);
            
            //dump($acg);
            //后置中间件,可以获取控制器和方法
            //判断session是否存在,是否是Login控制器下面的,会先将方法执行完,会浪费内存
            /*if(empty(session(config('admin.session_admin'))) && $request->controller()!="Login" )
            {
                return redirect(url('login/index'));
            }*/
            //return $acg;
            
        }
        
        //中间键结束
        public function end(\think\Response $response){
            //结束逻辑
            //echo 1;
        }
    }
?>
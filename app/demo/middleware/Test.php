<?php
    namespace app\demo\middleware;

    class Test
    {
        //handle必写
        public function handle($request, \Closure $next)
        {
            //dump(1);
            $request->type="冯志权";
            return $next($request);
        }
        
        //中间键结束
        public function end(\think\Response $response){
            //结束逻辑
            //echo 1;
        }
    }
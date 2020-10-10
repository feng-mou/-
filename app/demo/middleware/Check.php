<?php
    namespace app\demo\middleware;

    class Check
    {
        //handle必写,$request锟斤拷锟斤拷锟斤拷锟�
        public function handle($request, \Closure $next)
        {
            //dump(1);
            $request->type="Check_fzq";
            return $next($request);
        }
        
        //中间键结束
        public function end(\think\Response $response){
            //结束逻辑
            //echo 1;
        }
    }
?>
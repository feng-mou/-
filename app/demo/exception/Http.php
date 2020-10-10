<?php 
    namespace app\demo\exception;
    use think\exception\Handle;
    use think\Response;
    use Throwable;
    class Http extends Handle
    {
        public $httpStatus = 500;
        public function render($request, Throwable $e): Response
        {
            if(method_exists($e,"getStatusCode")){
                $httpStatus=$e->getStatusCode();
            }else{
                $httpStatus=$this->httpStatus;
            }
            //$httpStatus=$this->httpStatus;
            //echo $e->getStatusCode();
            // 添加自定义异常处理机制
            return show(config('status.error'),$e->getMessage(),[],$httpStatus);
        }
    }
?>
<?php
    namespace app\api\exception;
    use think\exception\Handle;
    use think\Response;
    use Throwable;
    class Http extends Handle
    {
        public $httpStatus = 500;
        public function render($request, Throwable $e): Response
        {
            /*if($e instanceof \think\Exception){
                return show($e->getCode(),$e->getMessage());
            }*/
            //前端判断是否登录返回提示逻辑
            if($e instanceof \think\exception\HttpResponseException){
                return parent::render($request, $e);
            }
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

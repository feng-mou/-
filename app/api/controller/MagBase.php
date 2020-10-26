<?php
    namespace app\api\controller;
    use app\BaseController;
    use think\exception\HttpResponseException;
    class MagBase extends BaseController {
        public function show(...$args)
        {
            throw new HttpResponseException(show(...$args));
        }
    }

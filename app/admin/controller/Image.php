<?php
    namespace app\admin\controller;
    class Image extends BaseAdmin{
        public function upload(){
            if(!$this->request->isPost()){
                return show(config('status.error'),"请求方式错误");
            }
            $file = $this->request->file('file');
            try{
                validate(['file' => [
                    // 限制文件大小(单位b)，这里限制为4M
                    'fileSize' => 4 * 1024 * 1024,
                    // 限制文件后缀，多个后缀以英文逗号分割
                    'fileExt'  => 'gif,jpg,png'
                ]])->check(['file' => $file]);
            }catch (\Exception $e){
                return show(config('status.error'),"图片格式错误");
            }
            // \think\Facade\Filesystem::putFile('img_test',$file);移动图片,img_test文件夹名字,$file文件
            //config文件下的filesystem文件改配置
            $fileName = \think\Facade\Filesystem::disk('public')->putFile('upload_img',$file);
            $path=\think\Facade\Filesystem::getDiskConfig('public', 'url').str_replace('\\', '/',$fileName);
            //echo $path;exit;
            if(!$fileName){
                return show(config('status.error'),"上传图片失败");
            }
            $imgUrl = [
                'image'=>$path,
            ];
            return show(config('status.success'),"上传成功",$imgUrl,200);
        }

        public function layUpload(){
            if(!$this->request->isPost()){
                return show(config('status.error'),"请求方式错误");
            }
            $file = $this->request->file('file');
            try{
                validate(['file' => [
                    // 限制文件大小(单位b)，这里限制为4M
                    'fileSize' => 4 * 1024 * 1024,
                    // 限制文件后缀，多个后缀以英文逗号分割
                    'fileExt'  => 'gif,jpg,png'
                ]])->check(['file' => $file]);
            }catch (\Exception $e){
                return show(config('status.error'),"图片格式错误");
            }
            // \think\Facade\Filesystem::putFile('img_test',$file);移动图片,img_test文件夹名字,$file文件
            //config文件下的filesystem文件改配置
            $fileName = \think\Facade\Filesystem::disk('public')->putFile('upload_img',$file);
            $path=\think\Facade\Filesystem::getDiskConfig('public', 'url').str_replace('\\', '/',$fileName);
            //echo $path;exit;
            if(!$fileName){
                return show(config('status.error'),"上传图片失败");
            }
            $json = [
                    "code"=>0,
                    "msg"=>"上传成功",
                    "data"=>[
                        "src"=>$path
                    ]
            ];
            return json($json,200);
        }
    }

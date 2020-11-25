<?php
use think\facade\Route;
//验证码api接口
Route::rule("smscode","Sms/code","POST");

//前台3级分类
Route::rule("category","Category/index","GET");

//个人用户信息接口 user为路由地址,User为控制器 only([允许的默认方法])
Route::resource("user","User")->only(['index', 'edit', 'update']);
//退出登录
Route::rule("logout","Logout/index","POST");
//app\demo\middleware\Check::class,
//Route::rule("zhonjian","Check/test","GET")->middleware(\app\demo\middleware\Test::class);
?>

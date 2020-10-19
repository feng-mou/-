<?php
use think\facade\Route;
//验证码api接口
Route::rule("smscode","Sms/code","POST");
//app\demo\middleware\Check::class,
//Route::rule("zhonjian","Check/test","GET")->middleware(\app\demo\middleware\Test::class);
?>

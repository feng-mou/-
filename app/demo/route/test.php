<?php
    use think\facade\Route;
    //路由访问data控制器下面的hello方法
    Route::rule("test","data/hello","GET");
    //app\demo\middleware\Check::class,
    Route::rule("zhonjian","Check/test","GET")->middleware(\app\demo\middleware\Test::class);
?>
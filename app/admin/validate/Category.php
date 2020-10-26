<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate{
    protected $rule = [
        'pid'=>'require',
        'name'=>'require',
    ];

    protected $message = [
        'name'=>'用户名必须',
        'pid'=>'上级必须',
    ];
    //只校验指定对象
    protected $scene = [
        //验证码参数校验
        'category_add'=>['name','pid'],
    ];
}
?>

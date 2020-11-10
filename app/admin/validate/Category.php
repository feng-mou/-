<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate{
    protected $rule = [
        'pid'=>'require',
        'name'=>'require',
        'id'=>'require',
        'listorder'=>'require|number',
    ];

    protected $message = [
        'name'=>'用户名必须',
        'pid'=>'上级必须',
        'id.require'=>'id必须',
        'listorder.require'=>"排序参数必须有",
        'listorder.number'  => '排序参数只能是数字',
    ];
    //只校验指定对象
    protected $scene = [
        //验证码参数校验
        'category_add'=>['name','pid'],
        //排序参数校验
        'category_listorder_edit'=>['id','listorder']
    ];
}
?>

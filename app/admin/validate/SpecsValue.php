<?php
namespace app\admin\validate;
use think\Validate;
class SpecsValue extends Validate{
    protected $rule = [
        'specs_id'=>'require',
        'name'=>'require|length:1,10',
    ];

    protected $message = [
        'specs_id.require'=>'用户名必须',
        'name.require'=>'密码必须',
        'name.length'=>'名字长度不符'
    ];

    //只校验指定对象
    protected $scene = [
        //添加规格属性参数校验
        'specs_add'=>['name','specs_id'],
    ];
}
?>

<?php
namespace app\demo\model;

use think\Model;

class User extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'tp6_test';
    // 设置字段信息
    protected $schema = [
        'id'            => 'int',
        'title'         => 'string',
        'pass'          => 'string',
        'category_id'   => 'int',
        'create_time'   => 'string',
        'update_time'   => 'string',
        'status'        =>'string',
    ];
    
    //获取器的作用是对模型实例的（原始）数据做出自动处理。一个获取器对应模型的一个特殊方法（该方法必须为public类型）
    //方法命名规范为：getFieldNameAttr
    //FieldName为数据表字段的驼峰转换，定义了获取器之后会在下列情况自动触发：
    public function getStatusAttr($value,$data)
     {
        $status = [
            0 =>'待审核',
            1 =>'正常',
            99 =>'删除'
        ];
        return $status[$data['status']];
     }
    
}
<?php
//该文件是放业务状态码提示的
//action_not_found方法不存在-3
//controller_not_found控制器不存在-2
//success 成功1
//error 错误0
    return [
        'action_not_found'=>-3,
        'controller_not_found'=>-2,
        'not_login'=>-1,
        'error'=>0,
        'success'=>1,
        //mysql相关状态配置
        'mysql'=>[
            'table_normal'=>1,//正常
            'table_pedding'=>-1,//待审核
            'table_delete'=>99//删除
        ]
    ];
?>

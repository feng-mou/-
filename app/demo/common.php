<?php
// 这是系统自动生成的公共文件

/*通用化API数据格式输出*/
//$status状态为json状态码
//$message是消息提示默认为error错误提示
//$data默认给个空数组
//$httpsSt 状态码
function show($status,$message="error",$data=[],$httpsSt = 200){
    $result = [
        "status"=>$status,
        "message"=>$message,
        "result"=>$data
    ];
    
    return json($result,$httpsSt);
}
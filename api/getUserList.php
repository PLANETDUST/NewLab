<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();
//1、接收用户参数
$role = @$_REQUEST['role'];
$status = @$_REQUEST['status'];
//2、验证用户输入
if(!isset($role) || !isset($status) || $role== '' || $status== ""){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}

$tool = new DataBaseTool();
if($role =='all'){
    $role = "";
}
if($status == 'all'){
    $status = '';
}

$sql = "SELECT * from users where role like '%$role%' and status like '%$status%'";
$result = $tool->selectAll($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否注册成功
    if($result){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"查询成功",
                'data'=>$result
            ]
            );
    }else{
        echo json_encode(
            [
                "code"=>500,
                "msg"=>"查询失败"
            ]
            );
    }
}else{
    echo json_encode(
        [
            "code"=>500,
            "msg"=>"SQL语句错误".$result
        ]
        );
}
?>

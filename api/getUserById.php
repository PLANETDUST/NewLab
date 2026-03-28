<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();
//1、接收用户参数
$id = @$_REQUEST['id'];
//2、验证用户输入
if(!isset($id) || $id == ""){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}

$tool = new DataBaseTool();
$sql = "SELECT * from users where id = '$id'";
$result = $tool->selectOne($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否查询成功
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
                "code"=>404,
                "msg"=>"用户不存在"
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
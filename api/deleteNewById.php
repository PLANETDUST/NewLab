<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
include __DIR__."/public/sql_waf.php";
session_start();
//1、接收用户参数
$nid = @$_REQUEST['nid'];
$role = @$_REQUEST['role'];
$nid = check_input($nid);
//2、验证用户输入
if(!isset($nid) || $nid== "" ){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}
$tool = new DataBaseTool();
$sql = "delete from new where id = $nid";
$result = $tool->delete($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否注册成功
    if($result){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"删除成功",
                'sql'=>$sql
            ]
            );
    }else{
        echo json_encode(
            [
                "code"=>500,
                "msg"=>"删除失败",
                'sql'=>$sql
            ]
            );
    }
}else{
    echo json_encode(
        [
            "code"=>500,
            "msg"=>"SQL语句错误".$result,
            'sql'=>$sql
        ]
        );
}
?>
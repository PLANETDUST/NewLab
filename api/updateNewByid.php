<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();
//1、接收用户参数
$nid = @$_REQUEST['nid'];
$title = @$_REQUEST['title'];
$content = @$_REQUEST['content'];
$newImgUrl = @$_REQUEST['newImgUrl'];
$uid = @$_REQUEST['uid'];
//2、验证用户输入
if(!isset($nid) || !isset($title) || !isset($content) || !isset($newImgUrl) || !isset($uid) || $nid== ''|| $title== "" || $content== "" || $newImgUrl== "" || $uid== ""){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}

$tool = new DataBaseTool();
$sql = "update new  set title='$title',content='$content',newImgUrl='$newImgUrl',uid=$uid where id=$nid";
$result = $tool->update($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否注册成功
    if($result){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"更新成功"
            ]
            );
    }else{
        echo json_encode(
            [
                "code"=>500,
                "msg"=>"更新失败"
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
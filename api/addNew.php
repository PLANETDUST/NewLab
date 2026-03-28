<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();
//1、接收用户参数
$title = @$_REQUEST['title'];
$content = @$_REQUEST['content'];
$newImgUrl = @$_REQUEST['newImgUrl'];
$uid = @$_REQUEST['uid'];
//2、验证用户输入
if(!isset($title) || !isset($content) || !isset($newImgUrl) || !isset($uid) || $title== "" || $content== "" || $newImgUrl== "" || $uid== ""){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}

$tool = new DataBaseTool();
$sql = "INSERT INTO new(title,content,newImgUrl,uid,newTime) VALUES('$title','$content','$newImgUrl',$uid,NOW())";
$result = $tool->insert($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否注册成功
    if($result){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"添加新闻成功"
            ]
            );
    }else{
        echo json_encode(
            [
                "code"=>500,
                "msg"=>"添加新闻失败"
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
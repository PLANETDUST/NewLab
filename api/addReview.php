<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
include __DIR__."/public/xss_waf.php";
session_start();
//1、接收用户参数
$review = @$_REQUEST['review'];
// $review = xss_waf($review);
$uid = @$_REQUEST['uid'];
$nid = @$_REQUEST['nid'];
//2、验证用户输入
if(!isset($review) || !isset($uid) || !isset($nid)  || $review==''|| $uid=="" || $nid=="" ){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}
$tool = new DataBaseTool();
$sql = "insert into reviews(review,reviewTime,uid,nid) values('$review',now(),$uid,$nid)";
$result = $tool->insert($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否注册成功
    if($result){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"评论成功"
            ]
            );
    }else{
        echo json_encode(
            [
                "code"=>500,
                "msg"=>"评论失败"
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
<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();

//构建SQL语句
$sql = "select reviews.id,users.username,reviews.review,new.title,reviews.reviewTime from new,reviews,users where users.id=reviews.uid and reviews.nid=new.id";
//执行SQL语句
//执行SQL
$tool = new DataBaseTool();
$result = $tool->selectAll($sql);
//判断语句是否成功
if(!is_string($result)){
    //判断 是否登录成功
    if($result != false){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"查询成功",
                "data"=>$result
            ]
        ); 
    }else{
        echo json_encode(
            [
                "code"=>402,
                "msg"=>"评论为空"
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
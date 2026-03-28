<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
include __DIR__."/public/sql_waf.php";
session_start();
//接收参数
$nid = @$_REQUEST['nid'];
$nid = check_input($nid);
if(!isset($nid)){
    echo json_encode(
        [
            "code"=>401,
            "msg"=>"缺失参数"
        ]
        );
        exit;
}
//构建SQL语句
$sql = "select new.id,new.title,new.content,newImgUrl,users.username,newTime from new,users where new.id=$nid and new.uid = users.id";
//执行SQL语句
//执行SQL
$tool = new DataBaseTool();
$result = $tool->selectOne($sql);
//判断语句是否成功
if(!is_string($result)){
    //判断 是否登录成功
    if($result != false){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"查询成功",
                "data"=>$result,
                "sql"=>$sql,
            ]
        ); 
    }else{
        echo json_encode(
            [
                "code"=>402,
                "msg"=>"无相关新闻",
                "sql"=>$sql,
            ]
            );
    }

}else{
    echo json_encode(
        [
            "code"=>500,
            "msg"=>"SQL语句错误".$result,
            "sql"=>$sql,
        ]
        );
    }
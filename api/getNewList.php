<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();
//接收参数
$search = @$_REQUEST['search'];
if(!isset($search)){
    echo json_encode(
        [
            "code"=>401,
            "msg"=>"缺失参数"
        ]
        );
        exit;
}
//构建SQL语句
$sql = 'select * from new where title like "%'.$search.'%"';
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
                "msg"=>"无相关新闻"
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
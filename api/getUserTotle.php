<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();

//准备SQL
$sql = "select count(*) as userTotle FROM users;";
//执行SQL
$tool = new DataBaseTool();
$result = $tool->selectOne($sql);
//判断语句是否成功
if(!is_string($result)){
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
            "code"=>500,
            "msg"=>"SQL语句错误".$result
        ]
        );
}
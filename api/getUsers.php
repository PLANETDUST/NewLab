<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();

$tool = new DataBaseTool();
$sql = "SELECT * from users";
$result = $tool->selectAll($sql);
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
                "msg"=>"无用户数据"
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
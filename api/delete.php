<?php
include __DIR__."/public/cors.php";


//1、接受 用户参数 文件名
$filename = $_REQUEST['filename'];
//2、构造目录路径
$path = __DIR__."/upload";
//3、构造文件 完整路径
$filePath = $path."/".$filename;
//4、删除文件
$result = unlink($filePath);
if($result){
    echo json_encode(
        [
            "code" => 200,
            "msg" => "删除成功"
        ]
        );
}else{
    echo json_encode(
        [
            "code" => 400,
            "msg" => "删除失败"
        ]
        );

}
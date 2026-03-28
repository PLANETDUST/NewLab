<?php
include __DIR__."/public/cors.php";
$file = $_FILES['file'];
//1、构造 文件路径
$path = __DIR__."/upload/";               //需要 有 写 权限
//2、构造 文件名  拿时间戳命名
$filename = time();
//3、获取 文件 拓展名
$ext = explode('.',$file['name'])[1];
//4、拼接 完整 路径
$filepath =  $path.$filename.".".$ext;


//5、移动文件
$result = move_uploaded_file($file['tmp_name'],$filepath);


//6、构造远程访问地址
$url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/upload/$filename.$ext";

//7、响应内容
if($result){
    echo json_encode(
        [
            "code" => 200,
            "msg" => "上传成功",
            "data" => [
                "url" => $url,
            ]
        ]
    );
}else{
    echo json_encode(
        [
            "code" => 400,
            "msg" => "上传失败",
        ]
    );
}

?>
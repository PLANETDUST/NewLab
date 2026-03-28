<?php
include __DIR__."/public/cors.php";
//构造 下载目录
$dir = __DIR__ . "/upload";
//构造 远程路径 http://www.new.com:88/upload/1769674434.png
$url_base = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER["HTTP_HOST"] . "/upload/";
//获取 目录下的 文件名
$fileList = scandir($dir);

//统计 文件大小
$countSize = 0;
//统计 文件数量
$count = 0;
//构造 数组
$data = [];
//遍历数组
foreach ($fileList as $filename) {
    //排除 . ..
    if ($filename != "." && $filename != "..") {
        // 拼接 远程 访问 路径
        $url = $url_base . $filename;
        // 获取 文件大小
        $filesize = round(filesize($dir . "/" . $filename) / 1024, 2);
        // 获取 文件 拓展名
        $ext = explode('.', $filename)[1];
        // 计算 文件总大小
        $countSize += $filesize;
        // 计算 文件数量
        $count++;
        // 构造 文件详细信息
        $file = [
                    "url" => $url,
                    "filename" => $filename,
                    "filesize" => $filesize ." KB",
                    "ext" => $ext,
                ];
        // 将 文件详细信息 添加到 数组中
        array_push($data,$file);
    }
}
// 响应内容
echo json_encode(
    [
        "code"=>200,
        "msg"=>"文件获取成功",
        "count"=>$count,
        "countSize"=>$countSize."KB",
        "data"=>$data,
    ]
);

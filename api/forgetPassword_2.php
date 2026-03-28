<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();

//接收 用户 参数
$email = $_REQUEST['email'];
$captcha = @$_REQUEST['captcha'];
//处理 判断 用户 输出 是否合规
if(!isset($email) || !isset($captcha) || $email == "" || $captcha == "" ){
    echo json_encode(
        [
            'code' => 400,
            'msg' => '参数错误'
        ]
        );
        exit;
}

//准备SQL
$sql = "select * from email_code where email = '$email' and captcha = $captcha";
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
                "msg"=>"验证成功",
            ]
        );
    }else{
        echo json_encode(
            [
                "code"=>401,
                "msg"=>"验证码错误"
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

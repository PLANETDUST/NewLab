<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();
//1、接收用户参数
$password = @$_REQUEST['password'];
$confirmPassword = @$_REQUEST['confirmPassword'];
$email = @$_REQUEST['email'];
//2、验证用户输入
if(!isset($password) || !isset($confirmPassword) || !isset($email) || $password== "" || $confirmPassword== "" || $email== ""){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}
//4、密码是否相同
if($password != $confirmPassword){
    echo json_encode(
        [
            "code" => 402,
            "msg" => "密码不一致"
        ]
    );
    exit;
}
//6、注册用户
$tool = new DataBaseTool();
$sql = "update users set password='$password' where email='$email'";
$result = $tool->update($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否注册成功
    if($result){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"重置密码成功"
            ]
            );
    }else{
        echo json_encode(
            [
                "code"=>500,
                "msg"=>"重置密码失败"
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
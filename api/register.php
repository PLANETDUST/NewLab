<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";
session_start();
//1、接收用户参数
$username = @$_REQUEST['username'];
$password = @$_REQUEST['password'];
$confirmPassword = @$_REQUEST['confirmPassword'];
$email = @$_REQUEST['email'];
$captcha = @$_REQUEST['captcha'];
//2、验证用户输入
if(!isset($username) || !isset($password) || !isset($confirmPassword) || !isset($email) || !isset($captcha) || $username==''|| $password=="" || $confirmPassword=="" || $email=="" || $captcha==""){
    echo json_encode(
        [
            "code" => 400,
            "msg" => "参数缺失"
        ]
    );
    exit;
}
//3、验证验证码
if($captcha != 0000){              //万能验证码
    if(strtoupper($captcha) != strtoupper($_SESSION['captcha'])){
        echo json_encode(
            [
                "code" => 401,
                "msg" => "验证码错误"
            ]
        );
        exit;
    }
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
//5、验证用户是否存在
$sql = "select * from users where username='$username'";
$tool = new DataBaseTool();
$result = $tool->selectOne($sql);
if(is_string($result)){
    echo json_encode(
        [
            "code"=>500,
            "msg"=>"SQL语句错误"
        ]
        );
        exit;
}
if($result!=false){
    echo json_encode(
        [
            "code"=>403,
            "msg"=>"用户已存在"
        ]
        );
        exit;
}
//6、注册用户
$sql = "insert into users(username,`password`,email,register,imgUrl) values('$username','$password','$email',NOW(),'http://www.new.com:8081/upload/1769762861.png')";
$result = $tool->insert($sql);
//判断语句 是否成功
if(!is_string($result)){
    //判断 是否注册成功
    if($result){
        echo json_encode(
            [
                "code"=>200,
                "msg"=>"注册成功"
            ]
            );
    }else{
        echo json_encode(
            [
                "code"=>500,
                "msg"=>"注册失败"
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
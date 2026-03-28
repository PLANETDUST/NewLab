<?php
include __DIR__ . "/public/cors.php";
include __DIR__ . "/public/dataBaseTool.php";

session_start();
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$confirm_password = $_REQUEST['confirm_password'];
$email = $_REQUEST['email'];
$role = $_REQUEST['role'];
$imgUrl = $_REQUEST['imgUrl'];
$status = $_REQUEST['status'];



if (!isset($username) || $username == "" || !isset($password) || $password == "" || !isset($confirm_password) || $confirm_password == "" || !isset($email) || $email == "" || !isset($role) || $role == "" ||!isset($imgUrl) || $imgUrl == "" || !isset($status) || $status == "" ) {
    echo json_encode(
        [
            'code' => 401,
            "msg" => "参数错误",
        ]
    );
    exit;
}

if($password != $confirm_password){
    echo json_encode(
        [
            "code" => 403,
            "msg" => "密码不一致",
        ]
    );
    exit;
}


$db = new DataBaseTool();
$sql = "insert into users(username,password,email,role,imgUrl,register,status) values('$username','$password','$email','$role','$imgUrl',now(),'$status');";
$result = $db->insert($sql);
if(is_bool($result)){
    if($result){
        echo json_encode(
            [
                "code" => 200,
                "msg" => "添加成功",
            ]
        );

    }else{
        echo json_encode(
            [
                "code" => 407,
                "msg" => "添加失败",
            ]
        );
    }

}else{
    echo json_encode(
        [
            "code" => 500,
            "msg" => '语句错误'.$result,
        ]
    );
}

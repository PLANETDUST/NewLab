<?php
include __DIR__."/public/cors.php";
include __DIR__."/public/dataBaseTool.php";


session_start();


//接收 用户 参数
$username = @$_REQUEST['username'];
$password = @$_REQUEST['password'];
$captcha = @$_REQUEST['captcha'];
//处理 判断 用户 输出 是否合规
if(!isset($username) || !isset($password) || !isset($captcha) || $username == "" || $password == "" || $captcha == ""){
    echo json_encode(
        [
            'code' => 400,
            'msg' => '参数错误'
        ]
        );
        exit;
}
//验证 验证码
if($captcha != '0000'){              //万能验证码
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
//先查询用户是否存在
$userSql = "select * from users where username = '$username'";
$tool = new DataBaseTool();
$userResult = $tool->selectOne($userSql);

//判断语句是否成功
if(!is_string($userResult)){
    //判断用户是否存在
    if($userResult != false){
        //用户存在，检查密码
        $storedPassword = $userResult[0]['password'];
        if($password == $storedPassword){
            //密码正确，登录成功
            echo json_encode(
                [
                    "code"=>200,
                    "msg"=>"登录成功",
                    "data"=>$userResult
                ]
            );
            $data = $userResult[0];
            setcookie('username',$data['username'],time()+3600*24*7,'/');
            setcookie('imgUrl',$data['imgUrl'],time()+3600*24*7,'/');
            setcookie('role',$data['role'],time()+3600*24*7,'/');
            setcookie('uid',$data['id'],time()+3600*24*7,'/');
        }else{
            //密码错误
            echo json_encode(
                [
                    "code"=>400,
                    "msg"=>"密码错误"
                ]
            );
        }
    }else{
        //用户不存在
        echo json_encode(
            [
                "code"=>400,
                "msg"=>"用户名错误"
            ]
        );
    }

}else{
    echo json_encode(
        [
            "code"=>500,
            "msg"=>"SQL语句错误".$userResult
        ]
    );
}
?>

<?php
    include __DIR__."/public/cors.php";
    include __DIR__."/public/dataBaseTool.php";
    session_start();
    setcookie('username',"",time()-3600*24*7,'/');
    setcookie('imgUrl',"",time()-3600*24*7,'/');
    setcookie('role',"",time()-3600*24*7,'/');
    setcookie('uid',"",time()-3600*24*7,'/');
    //删除 会话内容
    session_unset();
    //删除会话
    session_destroy();
    echo json_encode(
        [
            "code"=>"200",
            'msg'=>"退出登录成功"
        ])
?>
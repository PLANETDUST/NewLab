<?php

$id = $_REQUEST['id'];
if($id==""){
    echo json_encode([
        "code"=>200,
        "msg"=>"查询成功",
        'data'=>[
         [
            "id"=>1,
            "username"=>"张三",
            'password'=>'123456',
            'sfz'=>"3158xxxxxxxxx0000"
         ],
         [
            "id"=>2,
            "username"=>"张三",
            'password'=>'123456',
            'sfz'=>"3158xxxxxxxxx0000"
         ]
        ]
    ]);
} else if($id==1){
    echo json_encode(
        [
            "code"=>200,
            "msg"=>"查询成功",
            'data'=>[
             [
                "id"=>1,
                "username"=>"张三",
                'password'=>'123456',
                'sfz'=>"3158xxxxxxxxx0000"
             ]
            ]
        ]
             );
    
}
?>
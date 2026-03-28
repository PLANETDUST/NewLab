<?php
include __DIR__ . "/public/cors.php";
include __DIR__ . "/public/dataBaseTool.php";
include __DIR__ . "/sendEmail.php";
session_start();

//接收 用户 参数
$email = @$_REQUEST['email'];
//处理 判断 用户 输出 是否合规
if (!isset($email) || $email == "") {
    echo json_encode(
        [
            'code' => 400,
            'msg' => '参数错误',
        ]
    );
    exit;
}
$tool = new DataBaseTool();
//检测邮箱 是否 存在
$sql = "select * from users where email = '$email';";
$result = $tool->selectOne($sql);
if (!is_string($result)) {
    //判断 是否登录成功
    if ($result != false) {
        //如果存在 发送验证码 到邮箱 并且 数据库 记录 对应的邮箱和验证码
        $data = sendEmail($email);
        if ($data['code'] == 200) {

            $captcha = $data['authcode'];
            $sql = "insert into email_code(email,captcha) values('$email',$captcha)";
            $result = $tool->insert($sql);
            echo json_encode(
                [
                    "code" => 200,
                    "msg" => "验证码已发送到邮件，请注意查收",
                ]
            );
        } else {
            echo json_encode(
                [
                    "code" => 500,
                    "msg" => "服务器错误邮件发送失败",
                ]
            );
        }
    } else {
        echo json_encode(
            [
                "code" => 400,
                "msg" => "该邮箱不存在",
            ]
        );
    }

} else {
    echo json_encode(
        [
            "code" => 500,
            "msg" => "SQL语句错误" . $result,
        ]
    );
}

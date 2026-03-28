<?php
    // 导入核心包
    include __DIR__."/public/PHPMailer.php";
    include __DIR__."/public/SMTP.php";
    include __DIR__."/public/Exception.php";
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    
    // 实例化PHPMailer核心类
    function sendEmail($email)
    {
        $mail = new PHPMailer();
        try {
            // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
            $mail->SMTPDebug = 1;
            // 使用smtp鉴权方式发送邮件
            $mail->isSMTP();
            // smtp需要鉴权 这个必须是true
            $mail->SMTPAuth = true;
            // 链接qq域名邮箱的服务器地址
            $mail->Host = 'smtp.qq.com';
            // 设置使用ssl加密方式登录鉴权
            $mail->SMTPSecure = 'ssl';
            // 设置ssl连接smtp服务器的远程服务器端口号
            $mail->Port = 465;
            // 设置发送的邮件的编码
            $mail->CharSet = 'UTF-8';
            // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
            $mail->FromName = '新闻系统管理员';
            // smtp登录的账号 QQ邮箱即可
            $mail->Username = '本人邮箱';
            // smtp登录的密码 使用生成的授权码
            $mail->Password = '邮箱授权码';
            // 设置发件人邮箱地址 同登录账号
            $mail->From = '本人邮箱';
            // 邮件正文是否为html编码 注意此处是一个方法
            $mail->isHTML(true);
            // 设置收件人邮箱地址
            $mail->addAddress("$email");
            // 添加该邮件的主题
            $mail->Subject = '新闻系统邮件验证码';
            // 添加邮件正文,并生成 四位随机验证码
            $authcode = mt_rand(1000, 9999);
            $mail->Body = "<h3>新闻系统邮件验证码: $authcode </h3>";
            // 为该邮件添加附件
            # $mail->addAttachment('./example.pdf');
            // 不查看日志
            $mail->SMTPDebug = 0;
            // 发送邮件 返回状态 发送邮件的时候去数据库判断该邮箱是否存在于数据库并获得 uid
            $status = $mail->send();
            $mail->smtpClose();
            if ($status) {
                // 将 uid 验证码 存在数据 方便再次比对
                return
                [
                    "code" => 200,
                    "message" => "邮件发送成功,请注意查收",
                    "authcode"=>$authcode,
                ];
            } else {
                return
                [
                    "code" => 202,
                    "message" => "邮件发送失败,请稍后重试",
                ];
            }
        } catch (Exception $e) {
            return[
                "code" => 201,
                "message" => "邮件发送失败,请稍后重试",
            ];
        }
    }

?>
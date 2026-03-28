<?php
session_start();
$image_w = 80;
$image_h = 20;
// 定义图像宽度和高度
$image = imagecreatetruecolor($image_w, $image_h);
// 设置白色的图形
$white = imagecolorallocate($image, 255, 255, 255);
// 设置黑色的图形
$black = imagecolorallocate($image, 0, 0, 0);
// 将背景色填充到整个图像上
imagefill($image, 0, 0, $white);
//设置干扰点,使用 imagesetpixel()函数给图片添加干扰点。
for ($i = 0; $i < 100; $i++) {
imagesetpixel($image, rand(0, $image_w), rand(0, $image_h), $black);
}
// 生成随机验证码
// 验证码长度
$codeLength = 4;
// 所有可能的字符集合
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
$captchaCodes = '';
// 遍历生成随机次数
for ($i = 0; $i < $codeLength; $i++) {
    // 获取随机索引值
    $randomIndex = mt_rand(0, strlen($characters) - 1);
    // 从字符集中提取对应字符
    $captchaCode = substr($characters, $randomIndex, 1);
    //指定生成位置X、Y轴偏移量
    $x = ($i + 1) * 14;
    $y = $image_h / 8;
    // 设置一个随机颜色
    $color = imagecolorallocate($image, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 200));
    //imagestring()函数是PHP中的内置函数,用于水平绘制字符串。此函数在给定位置绘制字符串
    imagestring($image, 5, $x, $y, $captchaCode, $color);
    $captchaCodes .= $captchaCode;
}
// 保存验证码到session变量中供后续比对
$_SESSION['captcha'] = $captchaCodes;

// 输出图像
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
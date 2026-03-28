<?php

function xss_waf($str){
    $str = htmlspecialchars($str);
    $black = ['script','alert','on','javascript'];
    $str = str_ireplace($black,'xss_waf',$str);
    return $str;
}
?>
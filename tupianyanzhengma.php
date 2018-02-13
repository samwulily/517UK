<?php
session_start();

//创建图片    
$im = imagecreatetruecolor(50, 30);   
   
// 将背景设为蓝色    
$blue = imagecolorallocate($im, 100, 255, 255);   
//创建颜料    
$imgcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));   
//填充背景颜色    
imagefill($im, 0, 0, $blue);   
   
   
//画干扰线    
//for($i=0;$i<4;$i++){   
//    imageline($im,rand(0,20),0,100,rand(0,60),$imgcolor);   
//}   
   
//画噪点    
//for($i=0;$i<100;$i++){   
for($i=0;$i<10;$i++){
       
    imagesetpixel($im,rand(0,50),rand(0,30),$imgcolor);   
}   
   
//写字符串    
$str=substr(str_shuffle('ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'),0,4);   

//把验证码字符保存到session
$_SESSION["login_check_number"]=$str;    

imagestring($im,4,10,10,$str,$imgcolor);   
   
//输出图片    
header('content-type: image/png');   
imagepng($im);
echo "<br/>";
echo $str;   
//销毁图片    
imagedestroy($im);   
?>
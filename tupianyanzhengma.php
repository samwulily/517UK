<?php
session_start();

//����ͼƬ    
$im = imagecreatetruecolor(50, 30);   
   
// ��������Ϊ��ɫ    
$blue = imagecolorallocate($im, 100, 255, 255);   
//��������    
$imgcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));   
//��䱳����ɫ    
imagefill($im, 0, 0, $blue);   
   
   
//��������    
//for($i=0;$i<4;$i++){   
//    imageline($im,rand(0,20),0,100,rand(0,60),$imgcolor);   
//}   
   
//�����    
//for($i=0;$i<100;$i++){   
for($i=0;$i<10;$i++){
       
    imagesetpixel($im,rand(0,50),rand(0,30),$imgcolor);   
}   
   
//д�ַ���    
$str=substr(str_shuffle('ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'),0,4);   

//����֤���ַ����浽session
$_SESSION["login_check_number"]=$str;    

imagestring($im,4,10,10,$str,$imgcolor);   
   
//���ͼƬ    
header('content-type: image/png');   
imagepng($im);
echo "<br/>";
echo $str;   
//����ͼƬ    
imagedestroy($im);   
?>
<?php
session_start();
session_register("login_check_number");
//����������ʾ��ͼ��XXX���䱾���д��޷���ʾ�����ɾ���ȥ�����пո�
//�ȳ����������ٰ����ɵ���֤�����ȥ
$img_height=70;//�ȶ���ͼƬ�ĳ�����
$img_width=25;
$authnum='';
//������֤���ַ�
$ychar="0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
$list=explode(",",$ychar);
for($i=0;$i<4;$i++){
$randnum=rand(0,35);
$authnum.=$list[$randnum];
}
//����֤���ַ����浽session
$_SESSION["login_check_number"]=$authnum;
$aimg = imagecreate($img_height,$img_width);//����ͼƬ
imagecolorallocate($aimg,255,255,255);//ͼƬ��ɫ��ImageColorAllocate��1�ζ�����ɫPHP����Ϊ�ǵ�ɫ��
$black = imagecolorallocate($aimg,0,0,0);//������Ҫ�ĺ�ɫ
for($i=1;$i<=100;$i++){
imagestring($aimg,1,mt_rand(1,$img_height),mt_rand(1,$img_width),"@",imagecolorallocate($aimg,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
}
  
//Ϊ�������ڱ������������ɫ������200������Ĳ�С��200   
for($i=0;$i<strlen($authnum);$i++){
imagestring($aimg,mt_rand(3,5),$i*$img_height/4+mt_rand(2,7),mt_rand(1,$img_width/2-2),$authnum[$i],imagecolorallocate($aimg,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200)));
}
imagerectangle($aimg,0,0,$img_height-1,$img_width-1,$black);//��һ������
Header("Content-type: image/PNG");
ImagePNG($aimg);                    //����png��ʽ
ImageDestroy($aimg);
?>
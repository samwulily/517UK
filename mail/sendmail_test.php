<?php


$jmail=new COM('JMail.Message')or die('�޷�����Jmail���');


$jmail->logging='true';

$jmail->From='admin@517yingguo.cn'; //�����˵�ַ��Ҳ�������������ַ


$jmail->FromName='admin';//���������֣�������д���������ַ


$jmail->AddRecipient('samwulily@hotmail.co.uk');//�����˵�ַ 
//AddRecipient('xxx@xxx.com'); ������Ӻܶ�� Ⱥ��.


$jmail->Subject='PHP+Jmail���Է����ʼ�'; //�ʼ�����

$jmail->Body='PHP+Jmail���Է����ʼ�'; //�ʼ�����


$jmail->MailServerUserName='admin@517yingguo.cn';//��xxx@xxx.com��һ��Ϊ�����ʼ���ַ

$jmail->MailServerPassword='admin@517uk';//���������½����


$jmail->Send('smtp.517yingguo.cn');//mail.my-1.cnΪ���ǵ��ʾ�SMTP��ַ����Ҫ���������֤
echo ���ͳɹ�;
?>



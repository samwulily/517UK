<?php
//	Author: sam	Website: http://www.517yingguo.cn
//	$to receiver address	
//	$subject mail subtitle
//	$body	mail body
header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);
require './phpmailer/class.phpmailer.php';
try {
	$mail = new PHPMailer(true); 
	
	$mail->IsSMTP();
	$mail->SMTPDebug = 1;	//	����SMTP���Թ���
							//	1 = errors and messages
							//	2 = messages only
	$mail->SMTPKeepAlive = true;
	$mail->SMTPAuth = true;	//	����SMTP��֤����
//	$mail->SMTPSecure = "ssl";	//	��ȫЭ��
	$mail->CharSet='UTF-8'; //�����ʼ����ַ����룬�����Ҫ����Ȼ��������
	$mail->Port       = 25;                    
	$mail->Host       = "smtp.21cn.com"; 
	$mail->Username   = "wj_sam@21cn.com";    
	$mail->Password   = "1111";            
	//$mail->IsSendmail(); //���û��sendmail�����ע�͵���������֡�Could  not execute: /var/qmail/bin/sendmail ���Ĵ�����ʾ
	$mail->AddReplyTo("wj_sam@21cn.com","sam");//�ظ���ַ
	$mail->From       = "wj_sam@21cn.com";
	$mail->FromName   = "sam";
	$to = "wj_sam@163.com";
	$mail->AddAddress($to);
	$mail->Subject  = "phpmailer���Ա���";
	$mail->Body = "<h1>phpmail��ʾ</h1>����php���ͨ��<font color=red>www.phpddt.com</font>����phpmailer�Ĳ�������";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //���ʼ���֧��htmlʱ������ʾ������ʡ��
	$mail->WordWrap   = 80; // ����ÿ���ַ����ĳ���
	//$mail->AddAttachment("f:/test.png");  //������Ӹ���
	$mail->IsHTML(true); 
	$mail->Send();
	echo '�ʼ��ѷ���';
} catch (phpmailerException $e) {
	echo "�ʼ�����ʧ�ܣ�".$e->errorMessage();
}
?>
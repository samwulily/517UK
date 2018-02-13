<?php 
//header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);
//require_once '../phpmailer/class.phpmailer.php';
include '../phpmailer/class.phpmailer.php';

function yjmsendmail($to,$title,$body) {
	try {
		$mail = new PHPMailer(true); 
		
		$mail->IsSMTP();
		$mail->SMTPDebug = 1;	//	启用SMTP调试功能
								//	1 = errors and messages
								//	2 = messages only
		$mail->SMTPKeepAlive = true;
		$mail->SMTPAuth = true;	//	启用SMTP验证功能
	//	$mail->SMTPSecure = "ssl";	//	安全协议
		$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
		$mail->Port       = 25;                    
		$mail->Host       = "smtp.21cn.com"; 
		$mail->Username   = "wj_sam@21cn.com";    
		$mail->Password   = "1111";            
		//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
		$mail->AddReplyTo("wj_sam@21cn.com","sam");//回复地址
		$mail->From       = "wj_sam@21cn.com";
		$mail->FromName   = "sam";
		$mail->AddAddress($to);
		$mail->Subject  = $title;
		$mail->Body = $body;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
		$mail->WordWrap   = 80; // 设置每行字符串的长度
		//$mail->AddAttachment("f:/test.png");  //可以添加附件
		$mail->IsHTML(true); 
		$mail->Send();
		echo '邮件已发送';
	} catch (phpmailerException $e) {
		echo "邮件发送失败：".$e->errorMessage();
	}
}



//echo "<script>window.location =\"yongche.html\";</script>";

?> 

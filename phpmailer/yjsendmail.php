<?php 
//header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);
//require_once '../phpmailer/class.phpmailer.php';
include 'class.phpmailer.php';


$mailPort = "25";
$mailHost = "smtp.21cn.com";
$mailUsername = "wj_sam@21cn.com";
$mailPassword = "1111";    
$mailReplyToMailAddress = "wj_sam@21cn.com";
$mailReplyToDisplayName = "sam";
$mailSendFromMailAddress = "wj_sam@21cn.com";
$mailSendFromDisplayName = "sam";

/*
$mailPort = "25";
$mailHost = "mail.517yingguo.cn";
$mailUsername = "admin@517yingguo.cn";
$mailPassword = "Admin@517uk";    
$mailReplyToMailAddress = "admin@517yingguo.cn";
$mailReplyToDisplayName = "我要去英国网管理部";
$mailSendFromMailAddress = "admin@517yingguo.cn";
$mailSendFromDisplayName = "我要去英国网管理部";
*/
function yjmsendmail($to,$title,$body) {
	global $mailPort;
	global $mailHost;
	global $mailUsername;
	global $mailPassword;
	global $mailReplyToMailAddress; 
	global $mailReplyToDisplayName;
	global $mailSendFromMailAddress;
	global $mailSendFromDisplayName;
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
		$mail->Port       = $mailPort;                    
		$mail->Host       = $mailHost; 
		$mail->Username   = $mailUsername;    
		$mail->Password   = $mailPassword;            
		//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
		$mail->AddReplyTo($mailReplyToMailAddress,$mailReplyToDisplayName);	//回复地址
		$mail->From       = $mailSendFromMailAddress;
		$mail->FromName   = $mailSendFromDisplayName;
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

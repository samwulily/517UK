<?php
//	Author: sam	Website: http://www.517yingguo.cn
//	$to receiver address	
//	$subject mail subtitle
//	$body	mail body
function postmail_517($to,$subject = "",$body=""){
	echo "send to ".$to;
	echo "<br/>";
	error_reporting(E_STRICT);
	echo "before date_default_timezone_set";
	date_default_timezone_set("Asia/Shanghai");	//	set timezone east 8 zone
	require_once('class.phpmailer.php');
	include("class.smtp.php");
	$mail = new PHPMailer();	//	new an instance of PHPMailer class
	$body = eregi_replace("[\]",'',$body);	//	对邮件内容进行必要的过滤
	$mail->CharSet = "UTF-8";	//	设定邮件编码，默认ISO-8859-1,如果发中文此项必须设置，否则乱码
	$mail->IsSMTP();	//	设定使用SMTP服务
	$mail->SMTPDebug = 1;	//	启用SMTP调试功能
							//	1 = errors and messages
							//	2 = messages only
	$mail->SMTPAuth = true;	//	启用SMTP验证功能
//	$mail->SMTPSecure = "ssl";	//	安全协议
	$mail->SMTPSecure = "";	//	安全协议
	$mail->Host	= "mail.517yingguo.cn";	//	SMTP server
//	$mail->Port = 465;
	$mail->Port = 25;
	$mail->Username = "admin@517yingguo.cn";	//	SMTP username
	$mail->Password = "admin@517uk";	//	SMTP password
	$mail->SetFrom('admin@517yingguo.cn','admin');
	$mail->AddReplyTo("admin@517yingguo.cn","admin");
	$mail->Subject = $subject;
	$mail->AltBody = "To view the message, please use an HTML comatible email viewer!";
	$mail->MsgHTML($body);
	$address = $to;
	$mail->AddAddress($address,"customer");
	//$mail->AddAttachment("images/phpmailer.gif");	//	attachment
	//$mail->AddAttachment("images/phpmailer_mini.gif");	//	attachment
	if(!$mail->Send()){
		echo "Mailer Error:".$mail->ErrorInfo;
	}else{
		echo "Message sent success!";
	}
}



?>
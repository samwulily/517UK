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
	$body = eregi_replace("[\]",'',$body);	//	���ʼ����ݽ��б�Ҫ�Ĺ���
	$mail->CharSet = "UTF-8";	//	�趨�ʼ����룬Ĭ��ISO-8859-1,��������Ĵ���������ã���������
	$mail->IsSMTP();	//	�趨ʹ��SMTP����
	$mail->SMTPDebug = 1;	//	����SMTP���Թ���
							//	1 = errors and messages
							//	2 = messages only
	$mail->SMTPAuth = true;	//	����SMTP��֤����
//	$mail->SMTPSecure = "ssl";	//	��ȫЭ��
	$mail->SMTPSecure = "";	//	��ȫЭ��
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

$userID = $_GET['send_to'];
$nick_name = $_GET['nick_name'];
//echo "send to ".$userID." nick_name ".$nick_name;
$resendtime = time();
$token = md5($userID.$resendtime); //创建用于激活识别码  
$token_exptime = $resendtime+60*60*24;//过期时间为24小时后 

$updateActiveToken = "update user set token = '".$token."',token_exptime = '".$token_exptime."' 
						where username = '".$userID."'";
//echo $updateActiveToken;
mysql_query($updateActiveToken, $link) or die(mysql_error); 
mysql_close($link); 

$emailbody = "亲爱的".$nick_name."：<br/>感谢您在我要去英国网注册了新帐号。<br/>请点击链接激活您的帐号。<br/> 
    <a href=\"http://".$activeURL."activeUser.php?verify=".$token."\" target= 
\"_blank\">http://".$activeURL."activeUser.php?verify=".$token."</a><br/> 
    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";
	
//	echo "<script type = 'text/javascript'>alert('".$emailbody."');</script>";
	yjmsendmail($userID,'我要去英国网用户帐号激活',$emailbody);

?>
</body>
</html>
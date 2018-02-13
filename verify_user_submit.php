<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>CompanyName - PageName</title>
<meta http-equiv="Content-Language" content="en-us" /> 
<meta http-equiv="imagetoolbar" content="no" />
<meta name="MSSmartTagsPreventParsing" content="true" /> 
<meta name="description" content="Description" />
<meta name="keywords" content="Keywords" /> 
<meta name="author" content="Enlighten Designs" />
<style type="text/css" media="all">@import "css/master.css";</style>
<script type="text/javascript" src="js/ajaxmethod.js"></script>
</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 
<div id="content">  
<h1 align="center">提交重置密码请求</h1>
<?php
include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

session_start();

$yzm = $_POST['yzm'];

$session_yzm = $_SESSION["login_check_number"];

$resettime = time();
 
$token = md5($_POST['email'].$resettime); //创建重置密码识别码，防止被冒牌用户重置 
$token_exptime = time()+60*60*24;//过期时间为24小时后 

if($yzm!=$session_yzm){
	echo "<script>alert(\"验证码不正确!\");</script>";
	echo "<script>window.location.href = \"verify_user.php\"</script>";
}else{
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$checkUser = "select username,nick_name from user where username='".$_POST['email']."'";
	$result = mysql_query($checkUser);
	$no_value = True;
	while($row = mysql_fetch_array($result)){
		$nick_name = $row['nick_name'];
		$no_value = False;
	}

	if($no_value){
		echo "<script>alert(\"输入的邮件地址没有注册!\");</script>";
		echo "<script>window.location.href = \"regist.html\"</script>";
	}else{
			$passwordReset = "update user set updatepwd_token = '".$token."', 
			updatepwd_token_exptime = '".$token_exptime ."' where username = '".$_POST['email']."'";
			mysql_set_charset('utf8', $link); 
			mysql_query($passwordReset, $link) or die(mysql_error); 
			
			$emailbody = "亲爱的".$nick_name."：<br/>
			我们收到您重置密码的申请，请您在24小时内登陆以下地址，重置您的密码。<br/>
			<a href=\"http://".$activeURL."resetUserPwd.php?username=".$_POST['email']."&verify=
			".$token."\" target=\"_blank\">http://".$activeURL."resetUserPwd.php?username=".$_POST['email']."&verify=".$token."</a><br/>
			如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。";
		
			yjmsendmail($_POST['email'],'我要去英国网用户密码重置',$emailbody);
			
			echo "系统已将修改密码的链接发送至您的邮箱".$_POST['email']."，请尽快查收并修改密码。<br>
			如果您的收件箱中没有收到修改密码邮件，可以到邮件垃圾箱里找找，或者<a href=\"verify_user.php\">
			点击这里</a>重新发送修改密码邮件";

	}
	mysql_close($link); 
}

?>
</div>	
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
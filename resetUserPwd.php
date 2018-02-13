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
<script type="text/javascript">
function formsubmit(){
	var pwd = document.getElementById("pwd").value;
	var pwdagain = document.getElementById("pwdagain").value;
	if(pwd !== pwdagain){
		alert("两次输入的密码必须一致！");
		return false;
	}else{
		if(pwd.replace(/(^s*)|(s*$)/g,"").length < 6){
			alert("密码长度不得少于6个字符");
			return false;
		}else{
			document.getElementById("resetPwd").submit();
		}
	}
}
</script>
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
<h1 align="center">重置密码</h1>
<?php
include 'dbconnect.php';

if($_GET['username']){
	$verify = stripslashes(trim($_GET['verify'])); 
	$username = stripslashes(trim($_GET['username'])); 
	$nowtime = time(); 

	$link =mysql_connect($dbserver,$dbuser,$dbpwd)
		or die ("Could not connect server"); 
	mysql_select_db($dbname, $link) or die("database does not exist");

	$query = "select username,updatepwd_token_exptime from user where updatepwd_token='$verify'";
	$result = mysql_query($query,$link);
	$row = mysql_fetch_array($result); 
	if($row){ 
		if($nowtime>$row['updatepwd_token_exptime']){ //24hour 
			$msg = '您的激活有效期已过，请重新发送重置密码邮件.'; 
		}else{ 
			echo "<h2>请输入注册账号为".$username."的新密码！</h2>";
			echo "<form id=\"resetPwd\" action=\"resetUserPwdAction.php\" method=\"post\">";
			echo "<table>";
			echo "<input type=\"hidden\" name=\"username\" id=\"username\" value=".$username.">";
			echo "<tr><td>新密码</td><td><input type=\"password\" name=\"pwd\" id=\"pwd\" size=\"51\"></td></tr>";
			echo "<tr><td>再输入新密码</td><td><input type=\"password\" name=\"pwdagain\" id=\"pwdagain\" size=\"51\"></td></tr>";
			echo "<tr><td></td><td><button type=\"button\" onclick=\"formsubmit()\">提交</button></td></tr>";	
			echo "</table>";
			echo "</form>";
				
		//	$updateStatus = "update user set active_status=1 where username='".$row['username']."'";
		//	echo $updateStatus;
		//	mysql_query($updateStatus, $link) or die(mysql_error); 
		//    mysql_query($updateStatus); 
		//    if(mysql_affected_rows($link)!=1) die(0); 
		 
		} 
	}else{ 
		$msg = '您的密码重置链接无效，请重新发送密码重置请求邮件';     
	} 
}else{	//	没有 GET username 的值，不知道重置哪个用户名的密码，链接无效
	$msg = '您的密码重置链接无效，请重新发送密码重置请求邮件';
}
echo $msg; 	
?>
</div>	
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
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
<h1 align="center">用户注册结果</h1>

<?php 
	include 'dbconnect.php';
	session_start();
	$link =mysql_connect($dbserver,$dbuser,$dbpwd)
		or die ("Could not connect server"); 
	mysql_select_db($dbname, $link) or die("database does not exist");
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$selectUser = "select username,nick_name,active_status from user where username='".$_SESSION['username']."'";
//	echo $selectUser;
	if(isset($_SESSION['username'])){
		$result = mysql_query($selectUser,$link);
		while($row = mysql_fetch_array($result)){
			$nick_name = $row['nick_name'];
			$active_status = $row['active_status'];
		}	
	//	echo " nick_name:".$nick_name;
		if($active_status == 0){
			echo "<p>您的账户尚未激活</p>";
			echo "<p>请检查您的注册邮箱 ".$_SESSION['username']." 并按指示激活</p>";
			echo "<p>没有收到邮件？<button type=\"button\" onclick=\"resendActiveMail('".$_SESSION['username']."','".$nick_name."')\">重新发送激活邮件</button></p>";
			echo "<p>如果您的邮箱一直没有收到激活邮件，那您只能换一个邮箱<a href=\"regist.html\">重新注册</a></p>";
		}else if($active_status == 1){
			echo "<p>您的账户已激活</p>";
		}
	}else{
		echo "<script>alert(\"请登录!\");</script>";
		echo "<script>window.location.href = \"login.html\"</script>";
	}
	
?>
</div>	
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
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

<h1 align="center">用户中心</h1>
	<table align=center border=0>
<?php 
	include 'dbconnect.php';
	include 'phpmethod/commonMethod.php';
	session_start();

	error_reporting(0); 
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	$execgetUser = "select role_level from user where username='".$_SESSION['username']."'";
	$userresult = mysql_query($execgetUser);
	while($userrow = mysql_fetch_array($userresult)){	
		$role_level = $userrow['role_level'];
	}
	
	if($role_level=="0"){	//	0 是超级管理员
		echo "<tr><td><a href=\"manage.php?checktype=message\" target=\"_parent\">查看留言</a></td></tr>";
		echo "<tr><td><a href=\"manage.php?checktype=user\" target=\"_parent\">查看用户</a></td></tr>";
		echo "<tr><td><a href=\"manage.php?checktype=driver\" target=\"_parent\">查看司机</a></td></tr>";
		echo "<tr><td><a href=\"manage.php?checktype=order\" target=\"_parent\">查看订单</a></td></tr>";
	}else if($role_level=="2"){	//	2 是司导
		echo "<tr><td><a href=\"getuser.php?id=".$_SESSION['username']."\" target=\"_parent\">账号设置</a></td></tr>";
		echo "<tr><td><a href=\"\" target=\"_parent\">我的消息</a></td></tr>";
		echo "<tr><td><a href=\"bookcar.php?username=".$_SESSION['username']."\" target=\"_parent\">我的需求</a></td></tr>";
		echo "<tr><td><a href=\"transport.php?username=".$_SESSION['username']."\" target=\"_parent\">我的车源</a></td></tr>";
		echo "<tr><td><a href=\"getOffer.php?DGID=".$_SESSION['username']."\" target=\"_parent\">我的报价</a></td></tr>";
	}else{	//	1 是一般管理员，3 是普通用户  两者暂时显示内容一样
		echo "<tr><td><a href=\"getuser.php?id=".$_SESSION['username']."\" target=\"_parent\">账号设置</a></td></tr>";
		echo "<tr><td><a href=\"\" target=\"_parent\">我的消息</a></td></tr>";
		echo "<tr><td><a href=\"bookcar.php?username=".$_SESSION['username']."\" target=\"_parent\">我的需求</a></td></tr>";
		echo "<tr><td><a href=\"getFeedback.php?usrID=".$_SESSION['username']."\" target=\"_parent\">我的评价</a></td></tr>";
		echo "<tr><td><a href=\"\" target=\"_parent\">咨询回复</a></td></tr>";
		echo "<tr><td><a href=\"\" target=\"_parent\">投诉维权</a></td></tr>";
		echo "<tr><td><a href=\"upgradeuser.php?username=".$_SESSION['username']."\" target=\"_parent\">成为司导</a></td></tr>";
	}
?>
	</table>

</body>
</html>
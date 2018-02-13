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
</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 

<div id="sidebar-b">  
<div class="padding">
<iframe frameborder=0 width=120px height=200px marginheight=0 marginwidth=0 scrolling= no src="usr_center.php"></iframe>	
</div>
</div>	

<div id="content_a">  
<div class="padding">
<h1 align="center">用户评价信息</h1>

<?php 

	include 'dbconnect.php';
	include 'phpmethod/commonMethod.php';
	session_start();
	
//	error_reporting(0); 
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 

	$role_level = 3;	//	3 means 普通用户
	$re = getRoleLevel($link,$_SESSION['username'],$role_level);
//	echo "role_level:".$role_level;
	if(isset($_SESSION['nick_name'])){
		echo "<h2>乘客累计信用</h2>";
		echo "<table>";
		echo "<tr>";
		echo "<td></td>";		
		
	//	<img src="images/arrow.png" height=10px alt="arrow" />
		
		echo "<td><img src=\"images/general/good.jpg\" height=20px alt=\"好评\">好评</td>";
		echo "<td><img src=\"images/general/normal.jpg\" height=20px alt=\"中评\">中评</td>";
		echo "<td><img src=\"images/general/bad.jpg\" height=20px alt=\"差评\">差评</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>总计</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>";
		echo "</table>";
		if($role_level == 2){
			echo "<h2>司导累计信用</h2>";
		}
	}else{
		echo "<script>alert(\"请登录!\");</script>";
		echo "<script>window.location.href = \"login.html\"</script>";
	}
	mysql_close($link); 
?>
</div>	
</div>	
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
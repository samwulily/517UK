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
<div id="usr_login_reg"> 
	<table>
		<tr>
			<?php 
				include 'dbconnect.php';
				include 'phpmethod/commonMethod.php';
				session_start();
				$link =mysql_connect($dbserver,$dbuser,$dbpwd)
					or die ("Could not connect server"); 
				mysql_select_db($dbname, $link) or die("database does not exist");
				mysql_query("set character set 'gbk'"); 
				mysql_query("set character set 'utf8'");

				$rate		= "nothing";
				$update_time= "notime";	
				
				getGBPCNYRate($link,$rate,$update_time);
				
				if(isset($_SESSION['username'])){
					$selectUser = "select username,nick_name,active_status from user where username='".$_SESSION['username']."'";
				//	echo $selectUser;
					$result = mysql_query($selectUser,$link);
					while($row = mysql_fetch_array($result)){
						$nick_name = $row['nick_name'];
						$active_status = $row['active_status'];
					}	
					echo "<td>";
					echo "Welcome ".$nick_name."!";
					echo "</td>";
					echo "<td><a href=\"manage.php\" target=\"_parent\">用户中心</a></td>";
					echo "<td><a href=\"logout.php\" target=\"_parent\">退出</a></td>";
					if($active_status == 0){
						echo "<td>请<a href=\"regist_result.php\" target=\"_parent\">激活</a>您的账号！</td>";
					}
				}else{
					echo "<td>";
					echo "<a href=\"login.html\" onclick=\"addCurURL2Session()\" target=\"_parent\">登陆</a>";
					echo "</td>";
					echo "<td><a href=\"regist.html\" target=\"_parent\">注册</a></td>";
				}
				echo "<td><font color=red>|最新汇率：".$rate."更新时间".$update_time."【北京时间】</font></td>";
			?> 
		</tr>
	</table>
</div>
</body>
</html>
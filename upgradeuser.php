<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php include 'dbconnect.php';

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

$active_status = 0;
$jump_url = "";
$getUser = "select active_status from user where username = '".$_GET["username"]."'";
$result = mysql_query($getUser);
while($row = mysql_fetch_array($result)){	
	$active_status = $row['active_status'];
}
if($active_status == 0){
	echo "<script>alert('用户未激活,请激活您的账户')</script>";
	$jump_url = "regist_result.php";
}else{
	$exec = "update user set role_level = 2 where username = '".$_GET["username"]."'";
	echo $exec;
	mysql_set_charset('utf8', $link); 
	mysql_query($exec, $link) or die(mysql_error); 
	echo "<script>alert('升级司导成功！');</script>";
	$jump_url = "manage.php";
}
mysql_close($link); 
echo "<script type = 'text/javascript'>window.location.href = \"".$jump_url."\";</script>";
?> 
</body>
</html>

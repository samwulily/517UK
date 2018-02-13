<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>我要去英国网</title>
<meta http-equiv="Content-Language" content="en-us" /> 
<meta name="description" content="去英国" />
<meta name="keywords" content="我要去英国" /> 
<style type="text/css" media="all">@import "css/master.css";</style>
</head>
<body>
<?php include 'dbconnect.php';
header("Content-type:text/html;charset=UTF-8");
session_start();
$usr = $_POST["username"];
$pwd = md5($_POST["password"]);
$yzm = $_POST["yzm"];
$yzm2lower = strtolower($yzm);
$nick_name = "";
$role_level = 3;	//	3 means user

$session_yzm = $_SESSION["login_check_number"];
$s_yzm2lower = strtolower($session_yzm);

if($yzm2lower!=$s_yzm2lower){
	echo "<script>alert(\"验证码不正确!\");</script>";
	echo "<script>window.location.href = \"login.html\"</script>";
}else{
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	$exec = "select username,role_level,nick_name,active_status from user where username='".$usr."' and password='".$pwd."'";

	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$result = mysql_query($exec);
	$no_value = True;
	while($row = mysql_fetch_array($result)){
		$role_level = $row['role_level'];
		$nick_name = $row['nick_name'];
		$active_status = $row['active_status'];
		$no_value = False;
	}

	mysql_close($link); 

	if($no_value){
		echo "<script>alert(\"用户名或密码错!\");</script>";
		echo "<script>window.location.href = \"login.html\"</script>";
	}else{
		// store session username
		$_SESSION['username']=$usr;
		$_SESSION['nick_name']=$nick_name;
		if(isset($_SESSION['lastURL'])){
			$url = $_SESSION['lastURL'];
		}else{
			$url = "index.php";
		}
		echo $url;
		echo "<script>window.location.href = '".$url."'</script>";
			
	}
}
?> 
</body>
</html>

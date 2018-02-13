<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php
include 'dbconnect.php';
echo "username:".$_POST['username'].",password:".$_POST['pwd'].",password again:".$_POST['pwdagain'];	
$msg = "";
if($_POST['pwd'] == $_POST['pwdagain']){
	$link =mysql_connect($dbserver,$dbuser,$dbpwd)
		or die ("Could not connect server"); 
	mysql_select_db($dbname, $link) or die("database does not exist");
	$password = md5(trim($_POST['pwd'])); //加密密码 
	$updatePwd = "update user set password='".$password."' where username='".$_POST['username']."'";
//	echo $updatePwd;
	mysql_query($updatePwd, $link) or die(mysql_error); 
	$msg = "密码重置成功！";
}else{
	$msg = "两次输入的密码必须一致！";
}
echo "<script>alert('".$msg."');</script>";
echo "<script type = 'text/javascript'>window.location.href = \"login.html\";</script>";

?>
<?php 
header("Content-type:text/html;charset=UTF-8");
session_start();
//echo "YZM".$_GET["YZM"]."<br>";
//echo "session".$_SESSION["login_check_number"]."<br>";
if($_GET["YZM"]!=$_SESSION["login_check_number"]){
	echo "<font color=red>验证码不正确</font>";
}else{
	echo "<font color=green>验证码通过</font>";
}
?>

<?php
	include 'dbconnect.php';
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
    $sql="select * from user where username='$_GET[id]'";
    $query=mysql_query($sql);
    if(is_array(mysql_fetch_array($query))){
        echo "<font color=red>用户名已存在</font><a href=\"login.html\"> 登录</a>";
    }else{
        echo "<font color=green>用户名可以使用</font>";
    }
?>
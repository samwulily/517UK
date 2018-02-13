<?php include 'dbconnect.php';
header("Content-type:text/html;charset=UTF-8");
$conn = @mysql_connect($dbserver,$dbuser,$dbpwd);
if(!$conn){
	die("连接数据库失败：" . mysql_error());
}
mysql_select_db($dbname, $conn);
mysql_set_charset('utf8', $conn); 
$sql="select * from user where nick_name='$_GET[nickname]'";
$query=mysql_query($sql);
$hasrecord = false;
while($row = mysql_fetch_array($query,MYSQL_NUM)){
	$hasrecord = true;
}
if($hasrecord){
	echo "<font color=red>昵称已存在</font>";
}else{
	echo "<font color=green>昵称可以使用</font>";
}
	
mysql_free_result($query);
mysql_close($conn);
?>

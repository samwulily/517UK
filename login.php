
<?php include 'dbconnect.php';
header("Content-type:text/html;charset=UTF-8");
$usr = $_POST["username"];
$pwd = $_POST["password"];

echo "username:".$usr."<br/>";
echo "password:".$pwd."<br/>";

$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
if(!$link){
	die("connect db failed:".mysql_error());
}
mysql_select_db($dbname, $link); 
$exec = "select username from user where username='".$usr."' and password='".$pwd."'";
echo "statement:".$exec."<br/>";

mysql_query("set character set 'gbk'"); 
mysql_query("set character set 'utf8'");
$result = mysql_query($exec);
$no_value = True;
while($row = mysql_fetch_array($result)){
	echo "username:".$row['username']."<br/><br/>";
	$no_value = False;
}

mysql_close($link); 

if($no_value){
	echo "invalid user!<br/>";
}else{
	echo "Welcome ".$usr." !";
}

//window.location.target="_ablank";
//window.location.href="index.htm";

//echo "<script>window.location.target =\"_parent\";</script>";
//echo "<script>window.location.href =\"manage.html\";</script>";

?> 

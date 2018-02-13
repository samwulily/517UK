<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php 
include '../dbconnect.php';
include '../phpmailer/yjsendmail.php';
//header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);
//require '../phpmailer/class.phpmailer.php';

$treservetime = $_POST["hour"].":".$_POST["minute"];

$yongchetype = $_POST["yongchetype"];


if(strcmp($yongchetype,"接机")==0){
	$start_address = $_POST["ori_address_select"];
	$des_address = $_POST["des_address"];
}else if(strcmp($yongchetype,"送机")==0){
	$start_address = $_POST["ori_address"];
	$des_address = $_POST["des_address_select"];
}else{
	$start_address = $_POST["ori_address"];
	$des_address = $_POST["des_address"];
}

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist"); 
$exec="insert into bookcar (yongchetype,reservedate,reservetime,flight_number,
startAddress,startMark,destAddress,destMark,
userID,message,detail,advice_price,wish_price,booktime)
	values ('".$_POST["yongchetype"]."',
		 '".$_POST["date"]."',
		 '".$treservetime."',
		 '".$_POST["flight_number"]."',
		 '".$start_address."',
		 '".$_POST["ori_address_mark"]."',
		 '".$des_address."',
		 '".$_POST["des_address_mark"]."',
		 '".$_POST["reserve_person"]."',
		 '".$_POST["msg"]."',
		 '".$_POST["emailmsg"]."',
		 '".$_POST["price"]."',
		 '".$_POST["myprice"]."',
		 now())";
//echo $exec;
mysql_query("SET NAMES GB2312"); 
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 

$query="SELECT LAST_INSERT_ID()";
$result=mysql_query($query);
$rows=mysql_fetch_row($result);
//$rows[0];		这样就可以返回刚插入的记录的ID值了。
$reserveid = $rows[0];

mysql_close($link); 

echo "<script>window.location =\"../bookcar.php?id=".$reserveid."\";</script>";

?> 


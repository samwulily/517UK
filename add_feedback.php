<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");
mysql_query("set character set 'gbk'"); 
mysql_query("set character set 'utf8'");

$orderid = $_POST["orderID"];
$pass_or_dg = $_POST["pass_or_dg"];
$fback = $_POST["fback"];
$fback_level = $_POST["feedback_level"];

echo "orderid:".$orderid." passage or drive_guide:".$pass_or_dg." feedback:".$fback;

if($pass_or_dg == "pass"){
	$exec = "update bookcar set feedback_level_pass2dg = ".$fback_level.", feedback_pass2dg = '".$fback."' where reserveid = '".$orderid."'";
}else if($pass_or_dg == "dg"){
	$exec = "update bookcar set feedback_level_dg2pass = ".$fback_level.", feedback_dg2pass = '".$fback."' where reserveid = '".$orderid."'";
}
echo $exec;
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 

$getOrder = "select reserveid,userID,dgid from bookcar where reserveid = ".$orderid."";
$result = mysql_query($getOrder);
while($row = mysql_fetch_array($result)){	
	$custID = $row['userID'];
	$dgID = $row['dgid'];
}

$emailbody = "亲爱的用户，您成交的ID为".$orderid."的需求已经被对方评价，快去看看吧。详情请点击
				<a href=\"http://".$activeURL."bookcar.php?id=".$orderid."\" target=\"_blank\">
				http://".$activeURL."bookcar.php?id=".$orderid."</a>
				如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。";
			
if($pass_or_dg == "pass"){
	$sendto = $dgID;
}else if($pass_or_dg == "dg"){
	$sendto = $custID;
}			
$title = "您成交的ID为".$orderid."的需求已经被对方评价";
yjmsendmail($sendto,$title,$emailbody);

echo "<script type = 'text/javascript'>alert('评价成功！！');</script>";
//echo "<script type = 'text/javascript'>window.location.href = \"manage.php\";</script>";

mysql_close($link); 

?> 

<?php include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

header("Content-type:text/html;charset=UTF-8");

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

$getOrder = "select reserveid,userID from bookcar where reserveid='".$_GET['reserveid']."'";
mysql_query("set character set 'gbk'"); 
mysql_query("set character set 'utf8'");
$result = mysql_query($getOrder);
while($row = mysql_fetch_array($result)){	
	$custID = $row['userID'];
}

$exec = "delete from order_response where ORID = '".$_GET['offerID']."'"; 
//echo $exec;
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 
//echo "<script type = 'text/javascript'>window.location.href = \"manage.php\";</script>";

mysql_close($link); 

$emailbody = "亲爱的用户，我们很遗憾的通知您。有司导取消了给您的报价。请尽快查看。详情请点击
			<a href=\"http://".$activeURL."bookcar.php?id=".$_GET['reserveid']."\" target=\"_blank\">
			http://".$activeURL."bookcar.php?id=".$_GET['reserveid']."</a><br/>
			如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。";

yjmsendmail($custID,'有司导取消了给您的报价',$emailbody);

echo "报价已取消!";
?> 
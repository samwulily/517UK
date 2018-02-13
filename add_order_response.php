<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");
mysql_query("set character set 'gbk'"); 
mysql_query("set character set 'utf8'");

$exec="insert into order_response (orderID,DGID,offer_price,message,time)
	 values ('".$_POST["orderID"]."',
			 '".$_POST["DGID"]."',
			 '".$_POST["dgprice"]."',
			 '".$_POST["offerMsg"]."',
			 now())";
echo $exec;
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 

$getOrder = "select reserveid,userID from bookcar where reserveid = ".$_POST["orderID"]."";
$result = mysql_query($getOrder);
while($row = mysql_fetch_array($result)){	
	$custID = $row['userID'];
}
$emailbody = "亲爱的用户，您发布的用车需求已有司导回复。快去看看吧。详情请点击
			<a href=\"http://".$activeURL."bookcar.php?id=".$_POST["orderID"]."\" target=\"_blank\">
			http://".$activeURL."bookcar.php?id=".$_POST["orderID"]."</a><br/>
			如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。";

yjmsendmail($custID,'有司导给您报价啦',$emailbody);

echo "<script type = 'text/javascript'>alert('报价成功！！');</script>";
echo "<script type = 'text/javascript'>window.location.href = \"manage.php\";</script>";

mysql_close($link); 

?> 
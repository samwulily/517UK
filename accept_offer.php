
<?php include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

header("Content-type:text/html;charset=UTF-8");

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

$exec = "update bookcar set dgid = '".$_GET['dgID']."',final_price = '".$_GET['offer_price']."',status = 1 where reserveid = '".$_GET['reserveid']."'"; 
//echo $exec;
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 
//echo "<script type = 'text/javascript'>window.location.href = \"manage.php\";</script>";

mysql_close($link); 

$emailbody = "亲爱的司导用户，乘客接受了您的报价。快去看看吧。详情请点击
			<a href=\"http://".$activeURL."bookcar.php?id=".$_GET['reserveid']."\" target=\"_blank\">
			http://".$activeURL."bookcar.php?id=".$_GET['reserveid']."</a><br/>
			如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问。";		

yjmsendmail($_GET['dgID'],'有乘客接受您的报价啦',$emailbody);

//echo "成交!";
?> 
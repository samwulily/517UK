<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="20">
<title>CompanyName - PageName</title>
<meta http-equiv="Content-Language" content="en-us" /> 
<meta http-equiv="imagetoolbar" content="no" />
<meta name="MSSmartTagsPreventParsing" content="true" /> 
<meta name="description" content="Description" />
<meta name="keywords" content="Keywords" /> 
<meta name="author" content="Enlighten Designs" />
<style type="text/css" media="all">@import "css/master.css";</style>
<script type="text/javascript" src="js/ajaxmethod.js"></script>
<script type="text/javascript">

</script>
</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 
<h1 align="center">支付确认</h1>
<table>
	<tr>
<?php 
include 'dbconnect.php';

$payment_status = 0;	//	not paid
$payment_amount = 0;	

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

mysql_query("set character set 'gbk'"); 
mysql_query("set character set 'utf8'");


$exec = "select reserveid,final_price,pay_status from bookcar where reserveid = '".$_GET['orderID']."'";
$res = mysql_query($exec);
while($row = mysql_fetch_array($res)){
	$payment_status = $row['pay_status'];
	$payment_amount = $row['final_price'];
}

mysql_close($link);

if($payment_status == 1){
	echo "<table align=\"center\">";
	echo "<tr>";
	echo "<td><img src=\"images/general/yes.jpg\" height=30px alt=\"支付成功\"></td>";
	echo "<td>恭喜，您已成功支付".$payment_amount."英镑</td>";
	echo "</tr>";
	echo "<tr><td></td><td>订单号为".$_GET['orderID']."</td></tr>";
	echo "<tr><td></td><td><a href='bookcar.php?id=".$_GET['orderID']."'>查看订单详情</a></td></tr>";
	echo "</table>";
}else{
	echo "<table width=400 align=\"center\">";
	echo "<tr>";
	echo "<td><img src=\"images/general/no.jpg\" height=30px alt=\"支付未成功\"></td>";
	echo "<td>支付未成功。如果您看到这个页面，请不要着急。这有可能是PayPal和本网站的通讯滞后引起的。
我们会每隔10秒和PayPal重新确认支付状态。如果一个小时之后，订单支付状态仍然是未支付，请您和客服联系。
我们会人工确认支付状态。</td>";
	echo "</tr>";
	echo "<tr><td></td><td>订单号为".$_GET['orderID']."</td></tr>";
	echo "<tr><td></td><td><a href='bookcar.php?id=".$_GET['orderID']."'>查看订单详情</a></td></tr>";
	echo "</table>";
} 	

?>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>
</div>

</div>  



</body>
</html>


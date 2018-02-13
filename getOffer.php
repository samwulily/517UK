<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>CompanyName - PageName</title>
<meta http-equiv="Content-Language" content="en-us" /> 
<meta http-equiv="imagetoolbar" content="no" />
<meta name="MSSmartTagsPreventParsing" content="true" /> 
<meta name="description" content="Description" />
<meta name="keywords" content="Keywords" /> 
<meta name="author" content="Enlighten Designs" />
<style type="text/css" media="all">@import "css/master.css";</style>
<script type="text/javascript" src="js/ajaxmethod.js"></script>
</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 
<h1 align="center">我给出的报价</h1>

<?php 
	include 'dbconnect.php';
	require 'phpmethod/commonMethod.php';
			
	session_start();		
	error_reporting(0); 
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	
	if($_GET['DGID']){
		$exec = "select orderID,DGID,offer_price,message,time,decline from order_response 
		where DGID = '".$_GET['DGID']."' order by time";
		//	echo $exec;
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		$result = mysql_query($exec);
		$i = 1;
		
		echo "<table border=0 align=center>";
		
		echo "<tr><td></td><td>订单ID</td><td>司导ID</td><td>报价</td><td>留言</td><td>时间</td><td>状态</td><td></td></tr>";
		while($row = mysql_fetch_array($result)){	
			$getOrderInfo = "select status,dgid from bookcar where reserveid='".$row['orderID']."'";
		//	echo $getOrderInfo;
			$getOrderRe = mysql_query($getOrderInfo);
			while($orderRow = mysql_fetch_array($getOrderRe)){
				$status = getOrderStatus($orderRow['status']);
				$statusColor = getOrderStatusColor($orderRow['status']);
				//	如果状态为成交
				if($orderRow['status'] == 1){
					//	如果成交的司导就是登陆用户，状态显示”成功抢单“，如果是别的司导，显示”他人抢单“
				//	echo "抢单司导：".$orderRow['dgid']." 登陆用户：".$_SESSION['username']."<br>";
					if($orderRow['dgid'] == $_SESSION['username']){
						$status = "抢单成功";
					}else{
						$status = "被他人抢单";
						$statusColor = "black";
					}
				}
			}
			//	decline == 1 说明 offer 被乘客拒绝
			if($row['decline'] == 1){
				$status = "被拒绝";
				$statusColor = "black";
			}
			echo "<tr bgcolor=\"pink\">";
			echo "<td>第".$i++."条</td>";
			echo "<td>".$row['orderID']."</td>";
			echo "<td>".$row['DGID']."</td>";
			echo "<td>".$row['offer_price']."</td>";
			echo "<td>".$row['message']."</td>";
			echo "<td>".$row['time']."</td>";	
			echo "<td><font color=\"".$statusColor."\">".$status."</font></td>";
			echo "<td><a href=\"bookcar.php?id=".$row['orderID']."\">详情</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}else if($_GET['orderID']){
		echo "按照orderID 查找，orderID:".$_GET['orderID'];
	}
	mysql_close($link); 
?>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
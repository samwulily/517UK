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
</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 
<div id="sidebar-b">  
<div class="padding">
<iframe frameborder=0 width=120px height=200px marginheight=0 marginwidth=0 scrolling= no src="usr_center.php"></iframe>	
</div>
</div>	
<div id="content_a">  
<div class="padding">
<?php 
	include 'dbconnect.php';
	include 'phpmethod/commonMethod.php';
	session_start();

	error_reporting(0); 
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	$execgetUser = "select role_level from user where username='".$_SESSION['username']."'";
	$userresult = mysql_query($execgetUser);
	while($userrow = mysql_fetch_array($userresult)){	
		$role_level = $userrow['role_level'];
	}

	if(strcmp($_GET[checktype],"message")==0){
		$exec = "select message_id,company_name,module,address,username,phone,email,
			url,qq,company_brief,message,message_time from message_board order by message_time desc";
	}else if(strcmp($_GET[checktype],"user")==0){
		$exec = "select username,nick_name,role_level,phone_number,email from user where role_level = 3 order by reg_time";
	}else if(strcmp($_GET[checktype],"driver")==0){
		$exec = "select username,nick_name,role_level,phone_number,email from user where role_level = 2 order by reg_time";
	}else if(strcmp($_GET[checktype],"order")==0){
		$exec = "select reserveid,yongchetype,reservedate,reservetime,flight_number,
				startAddress,startMark,destAddress,destMark,userID,phone,
				message,detail,booktime 
				from bookcar order by booktime desc";
	}
	echo $exec;
//	echo $_SESSION['role_level'];
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$result = mysql_query($exec);
	$i = 1;
	
	if($role_level=="0"){	//	0 means 超级管理员
		echo "<table border=1 align=center>";
		if(strcmp($_GET[checktype],"message")==0){
			echo "<tr><td></td><td>公司名称</td><td>地址</td><td>联系人</td><td>联系电话</td><td>留言时间</td><td></td></tr>";
			while($row = mysql_fetch_array($result)){	
				echo "<tr bgcolor=\"pink\">";
				echo "<td>第".$i++."条</td>";
				echo "<td>".$row['company_name']."</td>";
				echo "<td>".$row['address']."</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['phone']."</td>";
				echo "<td>".$row['message_time']."</td>";
				echo "<td>";
				if($role_level=="0"){
					echo "<a href=\"delete_message.php?id=".$row['message_id']."\">删除</a></td></tr>";
				}
				echo "</td></tr>";
			}
		}else if(strcmp($_GET[checktype],"user")==0){
			echo "<tr><td></td><td>用户ID</td><td>昵称</td><td>用户等级</td><td>电话号码</td><td>电子邮件</td><td></td></tr>";
			while($row = mysql_fetch_array($result)){
				echo "<tr bgcolor=\"pink\">";
				echo "<td>第".$i++."条</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['nick_name']."</td>";
				echo "<td>".$row['role_level']."</td>";
				echo "<td>".$row['phone_number']."</td>";
				echo "<td>".$row['email']."</td>";
				echo "<td>";
				if($role_level=="0"){
					echo "<a href=\"delete_user.php?id=".$row['username']."&checktype=user\">删除</a></td></tr>";
				}
				echo "</td></tr>";
			}
		}else if(strcmp($_GET[checktype],"driver")==0){
			echo "<tr><td></td><td>用户ID</td><td>昵称</td><td>用户等级</td><td>电话号码</td><td>电子邮件</td><td></td><td></td></tr>";
			while($row = mysql_fetch_array($result)){
				echo "<tr bgcolor=\"pink\">";
				echo "<td>第".$i++."条</td>";
				echo "<td>".$row['username']."</td>";
				echo "<td>".$row['nick_name']."</td>";
				echo "<td>".$row['role_level']."</td>";
				echo "<td>".$row['phone_number']."</td>";
				echo "<td>".$row['email']."</td>";
				echo "<td>";
				echo "<a href=\"getuser.php?id=".$row['username']."\">详情</a></td>";
				echo "<td>";
				if($role_level=="0"){
					echo "<a href=\"delete_user.php?id=".$row['username']."&checktype=driver\">删除</a></td></tr>";
				}
				echo "</td></tr>";
			}
		}else if(strcmp($_GET[checktype],"order")==0){
			echo "<tr><td></td><td>用车类型</td><td>用车日期</td><td>用车时间</td><td>出发地址</td><td>到达地址</td><td>联系人</td><td>电话</td><td></td></tr>";
			while($row = mysql_fetch_array($result)){
				echo "<tr bgcolor=\"pink\">";
				echo "<td>第".$i++."条</td>";
				echo "<td>".$row['yongchetype']."</td>";
				echo "<td>".$row['reservedate']."</td>";
				echo "<td>".$row['reservetime']."</td>";
				echo "<td>".$row['startAddress']."</td>";
				echo "<td>".$row['destAddress']."</td>";
				echo "<td>".$row['userID']."</td>";
				echo "<td>".$row['phone']."</td>";
				echo "<td>";
				if($role_level=="0"){
					echo "<a href=\"delete_order.php?id=".$row['reserveid']."\">删除</a></td></tr>";
				}
				echo "</td></tr>";
			}	
		}
		echo "</table>";
	}else{		//	不是超级管理员显示以下
		echo "<h2>消息中心</h2>";
		echo "<table width = 100% aligh=center>";
		echo "<tr><td>未读消息</td></tr>";
		echo "</table>";
		echo "<br>";
		if($role_level=="3"||$role_level=="2")	//	2 是一般司导 3 是一般乘客
		{
			echo "<h2>乘客中心</h2>";
			$unpaid_order_num = 0;
			$reMsg = get_unpaid_order_num($link,$_SESSION['username'],$unpaid_order_num);
			$waiting_order_num = 0;
			$reMsg = get_waiting_order_num($link,$_SESSION['username'],$waiting_order_num);
			$waiting_feedbackpass2dg_num = 0;
			$reMsg = get_waiting_feedbackpass2dg_num($link,$_SESSION['username'],$waiting_feedbackpass2dg_num);
			echo "<table width=100% align=center>";
			echo "<tr>";
			echo "<td align=right>待付款</td><td align=left><font color=red>".$unpaid_order_num."</font></td>";
			echo "<td align=right>待成交</td><td align=left><font color=red>".$waiting_order_num."</font></td>";
			echo "<td align=right>待评价</td><td align=left><font color=red>".$waiting_feedbackpass2dg_num."</font></td>";
			echo "<td align=right>投诉</td><td align=left><font color=red></font></td>";
			echo "</tr>";
			echo "</table>";
		}
		echo "<br>";
		if($role_level=="2")	//	2 是一般司导
		{
			echo "<h2>司导中心</h2>";
			$unpaid_order_num = 0;
			$reMsg = get_unpaid_order_num($link,$_SESSION['username'],$unpaid_order_num);
			$waiting_order_num = 0;
			$reMsg = get_waiting_order_num($link,$_SESSION['username'],$waiting_order_num);
			echo "<table width=100% align=center>";
			echo "<tr>";
			echo "<td align=right>待付款</td><td align=left><font color=red>".$unpaid_order_num."</font></td>";
			echo "<td align=right>待成交</td><td align=left><font color=red>".$waiting_order_num."</font></td>";
			echo "<td align=right>待评价</td><td align=left><font color=red></font>";
			echo "<td align=right>投诉</td><td align=left><font color=red></font>";
			echo "</tr>";
			echo "</table>";
		}
		
	}
	mysql_close($link); 
?>
</div>  
</div>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>
</div>

</div>  

</body>
</html>


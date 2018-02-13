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
<script type="text/javascript">

function validate_required(field,alerttxt)
{
	with (field)
	{
		if (value==null||value==""){
			alert(alerttxt);return false
		}else {
			return true
		}
	}
}

function validate_form(thisform){
	with (thisform)
	{
		if (validate_required(dgprice,"报价必须填写！")==false) 
			{dgprice.focus();return false}
	}
}


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
<h1 align="center">需求详细信息</h1>
<table>
	<tr>
<?php 
	session_start();
	require './phpmethod/commonMethod.php';
	include 'dbconnect.php';
	error_reporting(0); 
	$tphone = "登录用户可见";
	$temail = "登录用户可见";
	$loginUserLevel = -1;
	$loginUserActiveStatus = 0;	//	0 是未激活
	
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$execGetUser = "select username,role_level,active_status,nick_name,phone_number,email,first_name,surname,country,city,
		address,postcode,brief from user where username='".$_SESSION['username']."'";
//	echo $execGetUser."<br>";
	$getUserRes = mysql_query($execGetUser);
	while($getUserRow = mysql_fetch_array($getUserRes)){	
		$loginUserLevel = $getUserRow['role_level'];
		$loginUserActiveStatus = $getUserRow['active_status'];
	}

	if($_GET[id]){
		$exec = "select reserveid,dgid,yongchetype,reservedate,reservetime,startAddress,startMark,
		destAddress,destMark,userID,message,advice_price,wish_price,final_price,status,pay_status,
		feedback_pass2dg,feedback_dg2pass,booktime
		from bookcar where reserveid='".$_GET[id]."'";
	}else if($_GET[username]){
		$exec = "select reserveid,dgid,yongchetype,reservedate,reservetime,startAddress,startMark,
		destAddress,destMark,userID,message,advice_price,wish_price,final_price,status,pay_status,
		feedback_pass2dg,feedback_dg2pass,booktime 
		from bookcar where userID='".$_GET[username]."' 
		order by booktime desc";		
	}else{
		$exec = "select reserveid,dgid,yongchetype,reservedate,reservetime,startAddress,startMark,
		destAddress,destMark,userID,message,advice_price,wish_price,final_price,status,pay_status,
		feedback_pass2dg,feedback_dg2pass,booktime
		from bookcar order by booktime desc";
	}

	$result = mysql_query($exec);
	echo "<table border=0 align=center>";
	$i = 1;
	if($_GET[id]){
		while($row = mysql_fetch_array($result)){	
			$status = getOrderStatus($row['status']);
			$statusColor = getOrderStatusColor($row['status']);
			$payStatus = getPayStatus($row['pay_status']);
			$payStatusColor = getPayStatusColor($row['pay_status']);
			$getUserInfo = "select phone_number,email,nick_name from user where username='".$row['userID']."'";			
			$res = mysql_query($getUserInfo);
			while($userow = mysql_fetch_array($res)){
				if(isset($_SESSION['username'])){
					//	登录用户为发布需求的用户，或者超级管理员，或者成交司导，可见电话号码，电邮
					if($_SESSION['username'] == $row['userID']||$loginUserLevel == 0||$_SESSION['username'] == $row['dgid']){
						$tphone = $userow['phone_number'];
						$temail = $userow['email'];
					}else{	//	否则显示成交司导用户可见
						$tphone = "成交司导用户可见";
						$temail = "成交司导用户可见";
					}	
				}
				$tnick_name = $userow['nick_name'];
			}
			echo "<tr><td>第".$i."条</td><td>";
			if($row['userID']==$_SESSION['username']){
				if($row['status'] == 0){	//	只有等待的状态才能取消，成交和流单的状态不能取消
					echo "<a href=\"cancel_order.php?id=".$row['reserveid']."\">取消</a>";
				}
			}
			echo "</td></tr>";
			echo "<tr><td>预定ID</td><td>".$row['reserveid']."</td></tr>";
			echo "<tr><td>用车类型</td><td>".$row['yongchetype']."</td></tr>";
			echo "<tr><td>用车日期</td><td>".$row['reservedate']."</td></tr>";
			echo "<tr><td>用车时间</td><td>".$row['reservetime']."</td></tr>";
			echo "<tr><td>出发地址</td><td>".$row['startAddress']."</td></tr>";
			echo "<tr><td>出发地址备注</td><td>".$row['startMark']."</td></tr>";
			echo "<tr><td>到达地址</td><td>".$row['destAddress']."</td></tr>";
			echo "<tr><td>到达地址备注</td><td>".$row['destMark']."</td></tr>";
			echo "<tr><td>联系人</td><td>".$tnick_name."</td></tr>";
			echo "<tr><td>电话</td><td>".$tphone."</td></tr>";
			echo "<tr><td>电子邮件</td><td>".$temail."</td></tr>";
			echo "<tr><td>参考报价</td><td>".$row['advice_price']."英镑</td></tr>";
			echo "<tr><td>乘客出价</td><td>".$row['wish_price']."英镑</td></tr>";
			echo "<tr><td>成交价</td><td>".$row['final_price']."英镑</td></tr>";
			echo "<tr><td>留言</td><td>".$row['message']."</td></tr>";
			echo "<tr><td>状态</td><td><font color=\"".$statusColor."\">".$status."</font></td></tr>";
			echo "<tr><td>付款状态</td><td><font color=\"".$payStatusColor."\">".$payStatus."</font></td>";
			echo "<td>";
			//	如果登录用户就是发布需求的用户，并且订单未付款，显示付款按钮
			if($row['pay_status']==0&&$_SESSION['username'] == $row['userID']){
			?>
				<form action="payment.php" method="post">
					<input type = "hidden" name="id" value = "<?php echo $row['reserveid']?>">
					<input type = "hidden" name="price" value = "<?php echo $row['wish_price']?>">
					<input name="Paypal" type="submit" value="现在付款">
				</form> 
			<?php
			}
			echo "</td></tr>";
			echo "<tr><td>下单时间</td><td>".$row['booktime']."</td></tr>";
			if($row['status'] == 1){	//	1 means 成交
				$getDealDGNickName = "select username,nick_name from user where username = '".$row['dgid']."'";
			//	echo $getDealDGNickName;
				$resgetDealDGNickName = mysql_query($getDealDGNickName);
				while($rowgetDealDGNickName = mysql_fetch_array($resgetDealDGNickName)){	
					$dealdgnickname = $rowgetDealDGNickName['nick_name'];
				}
				echo "<tr><td>接受任务司导</td><td><a href=\"driverGuide.php?id=".$row['dgid']."\">".$dealdgnickname."</a></td></tr>";
				
				//	取得当前时间和用车时间的差，看当前时间是否超过用车时间
				$arr_date = explode('/', $row['reservedate']);
				$arr_time = explode(':', $row['reservetime']);
				
				//	mktime(hour,minute,second,month,day,year)
				$reserve_time_stamp = mktime($arr_time[0],$arr_time[1],0,$arr_date[0],$arr_date[1],$arr_date[2]);
				$current_time = date("Y-m-d H:i:s");
			//	echo "当前时间".$current_time;
				//	echo "当前时间是：".$current_time."<br>";
				$currentTimeStamp = strtotime($current_time);
				$time_interval = $currentTimeStamp - $reserve_time_stamp;	//	取得当前时间和用车时间差
				if($time_interval > 3600)	//	如果当前时间比用车时间过了1个小时，3600秒，就可以评价对方
				{
					if(trim($row['feedback_pass2dg'])!=""&&trim($row['feedback_dg2pass'])!="")
					{
						$both_passdg_feedback = true;
					}
					//	如果登录用户为发布需求的乘客，并且没有评论
					if($_SESSION['username'] == $row['userID']){
						echo "<tr>";
						echo "<td>我的评价</td>";
						if(trim($row['feedback_pass2dg']) == ""){
							echo "<td>";
							echo "<form action=\"add_feedback.php\" method=\"post\" onsubmit=\"return validate_form(this)\">";
							echo "<table>";
							echo "<input type=\"hidden\" name=\"orderID\" id=\"orderID\" value=".$row['reserveid'].">";
							echo "<input type=\"hidden\" name=\"pass_or_dg\" id=\"pass_or_dg\" value=\"pass\">";
							echo "<tr>";
							//	radio feedback_level value 1 good 2 normal 3 bad 
							echo "<td>请选择<img src=\"images/general/good.jpg\" height=20px alt=\"好评\">好评
							<input type=\"radio\" name=\"feedback_level\" value=\"1\">	
							<img src=\"images/general/normal.jpg\" height=20px alt=\"中评\">中评
							<input type=\"radio\" name=\"feedback_level\" value=\"2\">
							或<img src=\"images/general/bad.jpg\" height=20px alt=\"差评\">差评
							<input type=\"radio\" name=\"feedback_level\" value=\"3\"></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td><textarea name=\"fback\" id=\"fback\" rows=\"4\" cols=\"40\"></textarea></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td><input type=\"submit\" value=\"提交\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							echo "</td>";
						}else{
							echo "<td>".$row['feedback_pass2dg']."</td>";
						}
						echo "</tr>";
					}else{
						echo "<tr><td>乘客评价</td>";
						if($both_passdg_feedback){
							echo "<td>".$row['feedback_pass2dg']."</td>";
						}
					}
					echo "</tr>";
				
					//	如果登录用户为领取任务的司导，并且没有评论
					if($_SESSION['username'] == $row['dgid']){
						echo "<tr>";
						echo "<td>我的评价</td>";
						if(trim($row['feedback_dg2pass']) == ""){	
							echo "<td>";
							echo "<form action=\"add_feedback.php\" method=\"post\" onsubmit=\"return validate_form(this)\">";
							echo "<table border=2>";
							echo "<input type=\"hidden\" name=\"orderID\" id=\"orderID\" value=".$row['reserveid'].">";
							echo "<input type=\"hidden\" name=\"pass_or_dg\" id=\"pass_or_dg\" value=\"dg\">";
							echo "<tr>";
							echo "<td><textarea name=\"fback\" id=\"fback\" rows=\"4\" cols=\"40\"></textarea></td>";
							echo "<td><input type=\"submit\" value=\"提交\"></td>";
							echo "</tr>";
							echo "</table>";
							echo "</form>";
							echo "</td>";
						}else{
							echo "<td>".$row['feedback_dg2pass']."</td>";
						}
						echo "</tr>";
					}else{
						echo "<tr><td>司导评价</td>";
						if($both_passdg_feedback){
							echo "<td>".$row['feedback_dg2pass']."</td>";
						}
					}
					echo "</tr>";
				}
			}
						
			//	如果登录用户就是发布需求的用户，他可以看所有司机的报价信息
			if($_SESSION['username'] == $row['userID']||$loginUserLevel == 0){
			//	echo "session username:[".$_SESSION['username']."] 发布需求的用户：[".$row['userID']."] 登录用户等级：[".$loginUserLevel."]";
				$getOrderRes = "select ORID,orderID,DGID,offer_price,message,time from order_response 
				where orderID =".$row['reserveid']." and decline=0";
								
			//	echo $getOrderRes;
				$resOrderRes = mysql_query($getOrderRes);
				echo "<table border=0 align=center>";
				while($rowOrderRes = mysql_fetch_array($resOrderRes)){	
					$getNickName = "select username,nick_name from user where username = '".$rowOrderRes['DGID']."'";
				//	echo $getNickName;
					$resGetNickName = mysql_query($getNickName);
					echo "<tr><td colspan=2>";
					while($rowGetNickName = mysql_fetch_array($resGetNickName)){	
						echo "<a href=\"driverGuide.php?id=".$rowGetNickName['username']."\">".$rowGetNickName['nick_name']."</a>";
						echo " 报价：".$rowOrderRes['offer_price']." 英镑 他/她还说：".$rowOrderRes['message'];
						if($row['status'] == 0){	// 只有状态为等待时才能成交
							echo "<button type=\"button\" onclick=\"accept_offer('".$row['reserveid']."','".$rowGetNickName['username']."','".$rowOrderRes['offer_price']."')\">接受</button>";
							echo "<button type=\"button\" onclick=\"decline_offer('".$row['reserveid']."','".$rowGetNickName['username']."','".$rowOrderRes['ORID']."')\">拒绝</button>";
						}
					}
					echo "</td></tr>";
				//	echo $rowOrderRes['offer_price']."<br>";
				}
				echo "</table>";
			}
			//	如果登录用户等级为司导，并且需求不是本人发布的
			else if($loginUserLevel == 2&&$_SESSION['username']!==$row['userID']){
				if($loginUserActiveStatus == 1)	//	1 means 激活的用户
				{
					$checkOffer = "select ORID,orderID,DGID,offer_price,message,time,decline from order_response
					where orderID = ".$row['reserveid']." and DGID ='".$_SESSION['username']."'";
				//	echo $checkOffer;
					$rescheckOffer = mysql_query($checkOffer);
					while($rowcheckOffer = mysql_fetch_array($rescheckOffer)){
						$offerGived = 1;	//	1 means gived offer already
						$offerID = $rowcheckOffer['ORID'];
						$offerPrice = $rowcheckOffer['offer_price'];
						$offerMessage = $rowcheckOffer['message'];
						$offer_decline = $rowcheckOffer['decline'];
					}
					if($offerGived == 1){
						echo "<tr><td colspan=2>我的报价: ".$offerPrice." 我的留言:".$offerMessage."</td></tr>";
						if($offer_decline == 1){	//	1 means 报价被乘客拒绝
							echo "<tr><td></td><td><font color=\"black\">报价被乘客拒绝</font></td></tr>"; 
						}
						if($row['status'] != 1){	//	1 means 成交,成交的交易不能由司导单方面取消
							echo "<tr><td></td><td><button type=\"button\" onclick=\"cancel_offer(".$offerID.",".$row['reserveid'].")\">取消报价</button></td></tr>";				
						}
						
					}else{
						if($row['status']==0){
							echo "<form action=\"add_order_response.php\" method=\"post\" onsubmit=\"return validate_form(this)\">";
							echo "<input type=\"hidden\" name=\"orderID\" id=\"orderID\" value=".$row['reserveid'].">";
							echo "<input type=\"hidden\" name=\"DGID\" id=\"DGID\" value=".$_SESSION['username'].">";
							echo "<tr><td>我要抢单</td>";
							echo "<td>我出价<input type=\"text\" id=\"dgprice\" name=\"dgprice\" size=\"5\"></td></tr>";
							echo "<tr><td>捎句话给乘客</td>";
							echo "<td><textarea name=\"offerMsg\" id=\"offerMsg\" rows=\"4\" cols=\"40\"></textarea></td></tr>";
							echo "<tr><td></td><td><input type=\"submit\" value=\"提交\"></td></tr>";
							echo "</form>";
						}
					}
				}else{
					echo "<tr><td colspan=2>未激活用户不能报价!</td></tr>";
				}
				
			}else if($loginUserLevel == 2){
				
			}
			$i++;
		}			 
	}else{
		echo "<tr><td></td><td>预定ID</td><td>用车类型</td><td>用车日期</td><td>用车时间</td><td>出发地址</td>
		<td>到达地址</td><td>联系人</td><td>乘客出价</td><td>状态</td><td>付款状态</td><td>评价状态</td>
		<td>下单时间</td>
		<td></td><td></td></tr>";
		while($row = mysql_fetch_array($result)){
			$status = getOrderStatus($row['status']);
			$statusColor = getOrderStatusColor($row['status']);
			$pay_status = getPayStatus($row['pay_status']);
			$pay_status_color = getPayStatusColor($row['pay_status']);
			$re = getFeedbackStatus($row['feedback_pass2dg'],$row['feedback_dg2pass'],$feedback_status);
			$getUserInfo = "select phone_number,email,nick_name from user where username='".$row['userID']."'";			
			$res = mysql_query($getUserInfo);
			while($userow = mysql_fetch_array($res)){
				$tphone = $userow['phone_number'];
				$temail = $userow['email'];
				$tnick_name = $userow['nick_name'];
			}
			echo "<tr bgcolor=\"pink\">";
			echo "<td>第".$i++."条</td>";
			echo "<td>".$row['reserveid']."</td>";
			echo "<td>".$row['yongchetype']."</td>";
			echo "<td>".$row['reservedate']."</td>";
			echo "<td>".$row['reservetime']."</td>";
			echo "<td>".$row['startAddress']."</td>";
			echo "<td>".$row['destAddress']."</td>";
			echo "<td>".$tnick_name."</td>";
			echo "<td>".$row['wish_price']."</td>";
			echo "<td><font color=\"".$statusColor."\">".$status."</font></td>";
			echo "<td><font color=\"".$pay_status_color."\">".$pay_status."</font></td>";
			echo "<td>".$feedback_status."</td>";
			echo "<td>".$row['booktime']."</td>";
			echo "<td><a href=\"bookcar.php?id=".$row['reserveid']."\">详情</a></td>";
			echo "<td>";
			echo "</td></tr>";
		}	
	}
	
	echo "</table>";
		
	mysql_close($link); 
?>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>
</div>

</div>  



</body>
</html>


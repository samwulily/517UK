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
<h1 align="center">付款结算信息</h1>
	<?php 
	include 'dbconnect.php';
	include 'phpmethod/commonMethod.php';
	
	$price = $_POST['price'];
	$id    = $_POST['id'];
	
	$link =mysql_connect($dbserver,$dbuser,$dbpwd)
		or die ("Could not connect server"); 
	mysql_select_db($dbname, $link) or die("database does not exist");
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");

	$rate		= "nothing";
	$update_time= "notime";	
	
	getGBPCNYRate($link,$rate,$update_time);
	$CNYPrice = $price * $rate; 
	$CNYPrice = round($CNYPrice,2);
	?>
	<div id="paypal">
		<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
		<table align=center width=96%>
			<tr>
				<input type="hidden" name="cmd" value="_xclick"> 
				<!--下面填写你的paypal账户email--> 
				<input type="hidden" name="business" value="samwulily-seller@hotmail.co.uk">
				<!--下面填写客户订单的一些相关信息，当客户连到paypal网站付款的时候将看到这些信息--> 
				<input type="hidden" name="item_name" value="order amount">
				<!--下面是订单的总金额信息--> 
				<input type="hidden" name="amount" value="<?php echo $price ?>">
				<!--下面是订单总金额对应的货币类型 ,客户可以用其他币种来付款,比如这里订单币种是英镑GBP,
				客户可以用欧元EUR来付款,由paypal根据当前汇率自动实现币种之间的换算--> 
				<input type="hidden" name="currency_code" value="GBP">
				<input type="hidden" name="on0" value="orderId"><!-- 自定义的参数1 --> 
				<input type="hidden" name="os0" value="<?php echo $id ?>"><!-- 对应上面自定义参数1对应的值 -->
				<!--告诉paypal付款的通信url,即当客户付款后调用这个url通知系统--> 
				<input type="hidden" name="notify_url" value="http://www.517yingguo.cn/paypal_notifyurl.php?orderID=<?php echo $id ?>">
				<input type="hidden" name="return" value="http://www.517yingguo.cn/bookcarPaymentConfirm.php?orderID=<?php echo $id ?>">
				<td width="15%"><img src="images/general/paypal_ico.png"></td>
				<td width="55%"><img src="images/general/paypal_list.png"></td>
				<td width="15%">支付金额：£<?php echo $price?></td>
				<td width="15%"><input name="Paypal" type="button" value="立即支付" onclick="javaScript:this.form.submit();"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan=2>使用Paypal支付，均以英镑结算,PayPal收取每张订单总金额3.4%+0.2英镑的手续费</td>
				
				<td></td>
			</tr>
		</table>
		</form>
	</div>
	<div id="gap">
		<table align=center width=96%>
			<tr>
                <td height="30" bgcolor="#F2F2F2">
                    &nbsp;
                </td>
            </tr>
		</table>
	</div>
	<div id="alipay">
	
		<form name=alipayment action="alipay/alipayapi.php" method=post target="_blank">
		<table align=center width=96%>
			<tr>
				<input type="hidden" name="WIDout_trade_no" value="<?php echo $id ?>"/>	<!-- 商户订单号 -->
				<input type="hidden" name="WIDsubject" value="我要去英国网订车费"/> <!-- 订单名称 -->
				<input type="hidden" name="WIDbody" />	<!-- 订单描述 -->
				<input type="hidden" name="WIDshow_url" />	<!-- 商品展示地址 -->
				<input type="hidden" name="WIDreceive_name" />	<!-- 收货人姓名	-->
				<input type="hidden" name="WIDreceive_address" />	<!-- 收货人地址	-->
				<input type="hidden" name="WIDreceive_zip" />	<!-- 收货人邮编	-->
				<input type="hidden" name="WIDreceive_phone" />		<!-- 收货人电话号码	-->
				<input type="hidden" name="WIDreceive_mobile" />	<!-- 收货人手机号码	-->
				<input type="hidden" name="WIDprice" value="0.01"/>
				<td width="15%"><img src="images/general/alipay_ico.png"></td>
				<td width="55%"></td>
				<td width="15%">支付金额：¥<?php echo $CNYPrice ?></td>
				<td width="15%"><input type="submit" value="立即支付"></td>
			</tr>
			<tr>
				<td></td>
				<td colspan=2>使用支付宝支付，均以人民币结算,支付宝收取每张订单总金额1.2%的手续费</td>
				
				<td></td>
			</tr>
		</table>
		</form>
	</div>	

<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>
</div>

</div>  
</body>
</html>



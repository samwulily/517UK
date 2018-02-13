<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */

?>
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
<style type="text/css" media="all">@import "../css/master.css";</style>
<script type="text/javascript" src="../js/ajaxmethod.js"></script>
</head>

<body>
<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="..\login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="..\nav.html"></iframe>
<div id="header">  
<h1><img src="../images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 
<h1 align="center">支付确认</h1>
<table>
	<tr>
<?php 
include '../dbconnect.php';
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//	初始设置未付款，交易金额为0.等取得正确的值，再修改	
$payment_status = 0;	
$payment_amount = 0;	

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];
	
	//交易价格
	$trade_price = $_GET['price'];
	
	$link =mysql_connect($dbserver,$dbuser,$dbpwd)
		or die ("Could not connect server"); 
	mysql_select_db($dbname, $link) or die("database does not exist");

	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");

	$exec = "select reserveid,final_price,pay_status from bookcar where reserveid = '".$out_trade_no."'";
	$res = mysql_query($exec);
	while($row = mysql_fetch_array($res)){
		$payment_status = $row['pay_status'];
		$payment_amount = $row['final_price'];
	}

	mysql_close($link);

	if($payment_status == 1){
		echo "<table align=\"center\">";
		echo "<tr>";
		echo "<td><img src=\"../images/general/yes.jpg\" height=30px alt=\"支付成功\"></td>";
		echo "<td>恭喜，您已成功支付".$trade_price."人民币</td>";
		echo "</tr>";
		echo "<tr><td></td><td>订单号为".$out_trade_no."</td></tr>";
		echo "<tr><td></td><td><a href='..\bookcar.php?id=".$out_trade_no."'>查看订单详情</a></td></tr>";
		echo "</table>";
	}else{
		echo "<table width=400 align=\"center\">";
		echo "<tr>";
		echo "<td><img src=\"../images/general/no.jpg\" height=30px alt=\"支付未成功\"></td>";
		echo "<td>支付未成功。如果您看到这个页面，请不要着急。这有可能是支付宝和本网站的通讯滞后引起的。
	我们会每隔10秒和支付宝重新确认支付状态。如果一个小时之后，订单支付状态仍然是未支付，请您和客服联系。
	我们会人工确认支付状态。</td>";
		echo "</tr>";
		echo "<tr><td></td><td>订单号为".$out_trade_no."</td></tr>";
		echo "<tr><td></td><td><a href='bookcar.php?id=".$out_trade_no."'>查看订单详情</a></td></tr>";
		echo "</table>";
	} 	

    if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
		echo "wait seller send goods";
		
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
		
	echo "验证成功<br />";
	echo "trade_no=".$trade_no;

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "验证失败";
}

?>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="..\footer.html"></iframe>
</div>

</div>  
</body>
</html>
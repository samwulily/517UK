<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

include '../comm.php';
include '../dbconnect.php';
include '../phpmailer/yjsendmail.php';

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

define("ALI_LOG_FILE", "../517yingguo_log/ali_ipn.log");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号
	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号
	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];
	
	//交易价格
	$trade_price = $_POST['price'];
	
	if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] '). "Enter alipay\notify_url.php, trade_no:"
										.$out_trade_no
										. "trade_status:"
										.$trade_status
										. "trade_price:"
										.$trade_price
										.PHP_EOL, 3, ALI_LOG_FILE);
	}
	
	if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
	//该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
	
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		    	//请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
			//如果有做过处理，不执行商户的业务程序
			
        echo "success";		//请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
	else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
	//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
	
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		    	//请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
			//如果有做过处理，不执行商户的业务程序
			
		$link =mysql_connect($dbserver,$dbuser,$dbpwd)
			or die ("Could not connect server"); 
		mysql_select_db($dbname, $link) or die("database does not exist"); 
		
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		$execGetOrder = "select userID,detail from bookcar where reserveid = '".$out_trade_no."'";
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "execGetOrder:".$execGetOrder. PHP_EOL, 3, ALI_LOG_FILE);
		}
		$getOrderRes = mysql_query($execGetOrder);
		while($getOrderRow = mysql_fetch_array($getOrderRes)){	
			$reserve_person = $getOrderRow['userID'];
			$reserve_detail = $getOrderRow['detail'];
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "reserve person:".$reserve_person." detail:".$reserve_detail. PHP_EOL, 3, ALI_LOG_FILE);
			}
		}
		
		//	pay_status = 1 means 已支付, pay_method = 1 means paypal , pay_method = 2 means alipay
		$exec = "update bookcar set pay_status = 1 ,
									pay_method = 2 ,	
									final_price = ".$trade_price." 
				where reserveid = '".$out_trade_no."'";
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "update pay_status sql:".$exec. PHP_EOL, 3, ALI_LOG_FILE);
		}		
		mysql_set_charset('utf8', $link); 
		mysql_query($exec, $link) or die(mysql_error); 
		mysql_close($link); 
		
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "Before yjmsendmail, send to:".$reserve_person.", detail: ".$reserve_detail. PHP_EOL, 3, ALI_LOG_FILE);
		}
		yjmsendmail($reserve_person,'订车',$reserve_detail);
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "After yjmsendmail". PHP_EOL, 3, ALI_LOG_FILE);
		}	
		
        echo "success";		//请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
	else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
	//该判断表示卖家已经发了货，但买家还没有做确认收货的操作
	
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		    	//请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
			//如果有做过处理，不执行商户的业务程序
			
        echo "success";		//请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
	else if($_POST['trade_status'] == 'TRADE_FINISHED') {
	//该判断表示买家已经确认收货，这笔交易完成
	
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
		    	//请务必判断请求时的price、quantity、seller_id与通知时获取的price、quantity、seller_id为一致的
			//如果有做过处理，不执行商户的业务程序
			
        echo "success";		//请不要修改或删除

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else {
		//其他状态判断
        echo "success";

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>
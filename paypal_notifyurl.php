<?php
include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

ini_set("magic_quotes_runtime",0);

// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.

define("LOG_FILE", "./517yingguo_log/ipn.log");

// Set to 0 once you're ready to go live
define("USE_SANDBOX", 1);

if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] '). "Test".PHP_EOL, 3, LOG_FILE);
	}

if($_GET['orderID']){
	$reserveid = $_GET['orderID'];
}else{
	$reserveid = -100;
}

// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}
// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data
if(USE_SANDBOX == true) {
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}
$ch = curl_init($paypal_url);
if ($ch == FALSE) {
	return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
if(DEBUG == true) {
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.
//$cert = __DIR__ . "./certificate/cacert.pem";
$cert = "./certificate/cacert.pem";
curl_setopt($ch, CURLOPT_CAINFO, $cert);
$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
	{
	if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL , 3, LOG_FILE);
	}
	curl_close($ch);
	exit;
} else {
		// Log the entire HTTP response if debug is switched on.
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL , 3, LOG_FILE);
			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL , 3, LOG_FILE);
		}
		curl_close($ch);
}
// Inspect IPN validation result and act accordingly
// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp ($res, "VERIFIED") == 0) {
	// check whether the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment and mark item as paid.
	// assign posted variables to local variables
	//$item_name = $_POST['item_name'];
	//$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$payer_email = $_POST['payer_email'];
	
	if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] ')
		. "+++++++++payment status:".$payment_status
		." txn_id:".$txn_id
		." receiver_email:".$receiver_email
		." payment amount:".$payment_amount
		." payment currency:".$payment_currency
		." payer email:".$payer_email
		. PHP_EOL, 3, LOG_FILE);
	} 
	
	if(strcmp($payment_status,"Completed") == 0){	//	payment status 为 Completed为付款成功，其他为不成功
		$link =mysql_connect($dbserver,$dbuser,$dbpwd)
			or die ("Could not connect server"); 
		mysql_select_db($dbname, $link) or die("database does not exist"); 
		
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		$execGetOrder = "select userID,detail from bookcar where reserveid = '".$reserveid."'";
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "execGetOrder:".$execGetOrder. PHP_EOL, 3, LOG_FILE);
		}
		$getOrderRes = mysql_query($execGetOrder);
		while($getOrderRow = mysql_fetch_array($getOrderRes)){	
			$reserve_person = $getOrderRow['userID'];
			$reserve_detail = $getOrderRow['detail'];
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "reserve person:".$reserve_person." detail:".$reserve_detail. PHP_EOL, 3, LOG_FILE);
			}
		}
		
		//	pay_status = 1 means 已支付, pay_method = 1 means paypal 
		$exec = "update bookcar set pay_status = 1 ,
									pay_method = 1 ,	
									final_price = ".$payment_amount." ,
									paypal_notify = '".$raw_post_data."' 
				where reserveid = '".$reserveid."'";
		mysql_set_charset('utf8', $link); 
		mysql_query($exec, $link) or die(mysql_error); 
		mysql_close($link); 
		
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "Before yjmsendmail, send to:".$reserve_person.", detail: ".$reserve_detail. PHP_EOL, 3, LOG_FILE);
		}
		yjmsendmail($reserve_person,'订车',$reserve_detail);
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "After yjmsendmail". PHP_EOL, 3, LOG_FILE);
		}
	}else{
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "!!!!!!!!!!Payment status: $payment_status ". PHP_EOL, 3, LOG_FILE);
		}
	}
	
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
	}
} else if (strcmp ($res, "INVALID") == 0) {
	// log for manual investigation
	// Add business logic here which deals with invalid IPN messages
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
	}
}



?>
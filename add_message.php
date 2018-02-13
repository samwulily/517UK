<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php include 'dbconnect.php';

function uuid()
{
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
}

$GUID = uuid();
//echo $GUID;

//header("Content-type:text/html;charset=UTF-8");

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist"); 
$exec="insert into message_board (message_id,company_name,module,address,coordinator,phone,email,url,qq,company_brief,message,message_time)
 values ('".$GUID."',
		 '".$_POST["companyName"]."',
		 '".$_POST["module"]."',
		 '".$_POST["address"]."',
		 '".$_POST["coordinator"]."',
		 '".$_POST["phoneNumber"]."',
		 '".$_POST["email"]."',
		 '".$_POST["homepage"]."',
		 '".$_POST["qqmsn"]."',
		 '".$_POST["companyProfile"]."',
		 '".$_POST["message"]."',
		 now())";
echo $exec;
//mysql_query("SET NAMES GB2312"); 
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 
mysql_close($link); 

echo "insert success";

echo "<script>window.location =\"query.html\";</script>";

//$url="query.html"; 
//echo "<!--<scr¨©pt LANGUAGE="Javascr¨©pt">"; 
//echo "location.href='$url'"; 
//echo "</scr¨©pt>-->"; 

?> 
</body>
</html>
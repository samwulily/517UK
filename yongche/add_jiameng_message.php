
<?php include '../dbconnect.php';
include '../mail/yjsendmail.php';
//header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);

function uuid()
{
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
}

$GUID = uuid();

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist"); 
$exec="insert into jiameng (id,company_person_name,address,postcode,coordinator,phone,email,url,qqmsn,
company_brief,message,submit_time)
	values ('".$GUID."',
		 '".$_POST["companyName"]."',
		 '".$_POST["address"]."',
		 '".$_POST["postcode"]."',
		 '".$_POST["coordinator"]."',
		 '".$_POST["phoneNumber"]."',
		 '".$_POST["email"]."',
		 '".$_POST["homepage"]."',
		 '".$_POST["qqmsn"]."',
		 '".$_POST["companyProfile"]."',
		 '".$_POST["message"]."',
		 now())";

echo $exec;

$emailbody = "公司：".$_POST["companyName"]."<br>地址：".$_POST["address"]."<br>邮编：".$_POST["postcode"]."<br>联系人：".$_POST["coordinator"]."<br>电话：".$_POST["phoneNumber"]."<br>电邮：".$_POST["email"]."<br>网址：".$_POST["email"]."<br>QQ/MSN:".$_POST["qqmsn"]."<br>公司简介：".$_POST["companyProfile"]."<br>留言：".$_POST["message"];

mysql_query("SET NAMES GB2312"); 
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 
mysql_close($link); 

yjmsendmail('wj_sam@163.com','车辆加盟',$emailbody);

echo "<script>window.location =\"jiameng.html\";</script>";

?> 


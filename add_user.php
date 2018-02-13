<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />

<?php 
ini_set("magic_quotes_runtime",0);
include 'dbconnect.php';
include 'comm.php';
include 'phpmailer/yjsendmail.php';

session_start();
$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

$userID = trim($_POST["email"]);

$checkUsr = "select username from user where username='$userID'";
//echo $checkUsr;
$result = mysql_query($checkUsr,$link);
$exist = false;
while($row = mysql_fetch_array($result)){
	$exist = true;
}	

$password = md5(trim($_POST['pwd'])); //加密密码 
$nick_name = trim($_POST['nick_name']);
$phone_number = trim($_POST['phoneNumber']);
$regtime = time();
 
$token = md5($userID.$regtime); //创建用于激活识别码 
$token_exptime = $regtime+60*60*24;//过期时间为24小时后 
 
if($exist == true ){
	echo "<script type = 'text/javascript'>alert('用户名已存在');location='javascript:history.back()';</script>";
}else{
	$exec="insert into user (username,password,role_level,token,token_exptime,nick_name,phone_number,email,reg_time)
	 values ('".$userID."',
			 '".$password."',
			 3,
			 '".$token."',
			 '".$token_exptime."',
			 '".$nick_name."',
			 '".$phone_number."',
			 '".$userID."',	
			 now())";
	//	目前userID和email一样		 
			 
	echo $exec;
	//mysql_query("SET NAMES GB2312"); 
	mysql_set_charset('utf8', $link); 
	mysql_query($exec, $link) or die(mysql_error); 
	// store session username
	$_SESSION['username']=$_POST["email"];
	$_SESSION['nick_name']=$_POST["nick_name"];
//	$_SESSION['role_level']=3;

	$emailbody = "亲爱的".$nick_name."：<br/>感谢您在我要去英国网注册了新帐号。<br/>请点击链接激活您的帐号。<br/> 
    <a href=\"http://".$activeURL."activeUser.php?verify=".$token."\" target= 
\"_blank\">http://".$activeURL."activeUser.php?verify=".$token."</a><br/> 
    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";
	yjmsendmail($userID,'我要去英国网用户帐号激活',$emailbody);
//	echo "<script type = 'text/javascript'>alert('注册成功！！');</script>";
	echo "<script type = 'text/javascript'>window.location.href = \"regist_result.php\";</script>";
}
mysql_close($link); 

?> 
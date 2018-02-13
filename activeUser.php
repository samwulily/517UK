<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php
include 'dbconnect.php';
 
$verify = stripslashes(trim($_GET['verify'])); 
$nowtime = time(); 

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

$query = "select username,token_exptime from user where active_status=0 and token='$verify'";
$result = mysql_query($query,$link);
$row = mysql_fetch_array($result); 
if($row){ 
    if($nowtime>$row['token_exptime']){ //24hour 
        $msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.'; 
    }else{ 
		$updateStatus = "update user set active_status=1 where username='".$row['username']."'";
		echo $updateStatus;
		mysql_query($updateStatus, $link) or die(mysql_error); 
    //    mysql_query($updateStatus); 
    //    if(mysql_affected_rows($link)!=1) die(0); 
        $msg = '您在我要去英国网的账户成功激活！'; 
    } 
}else{ 
    $msg = '您的激活链接无效，请登录您的账号重新发送激活邮件';     
} 
echo "<script>alert('".$msg."');</script>";
echo "<script type = 'text/javascript'>window.location.href = \"manage.php\";</script>";
?>
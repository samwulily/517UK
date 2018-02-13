<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<?php include 'dbconnect.php';
//include 'mail/yjsendmail.php';
ini_set("magic_quotes_runtime",0);

//$imagefolder = "images/user/".$_POST['username']."/".$_POST['reg_year'].$_POST['brand'].time();
$imagefolder = "images/user/".$_POST['username']."/".time();
echo $imagefolder;

if(!file_exists($imagefolder)){  
	mkdir($imagefolder);  
}  

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist"); 
$exec="insert into transport (username,transtype,brand,reg_year,reg_code,description,imgfolder,add_time)
	values ('".$_POST["username"]."',
		 '".$_POST["transtype"]."',
		 '".$_POST["brand"]."',
		 '".$_POST["reg_year"]."',
		 '".$_POST["reg_code"]."',
		 '".$_POST["description"]."',
		 '".$imagefolder."',
		 now())";
echo $exec;
mysql_query("SET NAMES GB2312"); 
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 
mysql_close($link); 

//echo "<script>window.location =\"../manage.php\";</script>";

?> 


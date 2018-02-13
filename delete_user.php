
<?php include 'dbconnect.php';

$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
mysql_select_db($dbname, $link); 
$del_id=$_GET["id"]; 
$checktype = $_GET["checktype"];
$exec="delete from user where username ='".$del_id."'"; 
echo $exec;
echo "<br/>";
mysql_query($exec, $link); 
mysql_close($link); 

echo "<script>window.location =\"manage.php?checktype=".$checktype."\";</script>";
?> 

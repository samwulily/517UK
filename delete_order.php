
<?php include 'dbconnect.php';

$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
mysql_select_db($dbname, $link); 
$del_id=$_GET["id"]; 
$exec="delete from bookcar where reserveid ='".$del_id."'"; 
echo $exec;
echo "<br/>";
mysql_query($exec, $link); 
mysql_close($link); 

echo "<script>window.location =\"manage.php?checktype=order\";</script>";
?> 


<?php include 'dbconnect.php';

header("Content-type:text/html;charset=UTF-8");

$link =mysql_connect($dbserver,$dbuser,$dbpwd)
	or die ("Could not connect server"); 
mysql_select_db($dbname, $link) or die("database does not exist");

$exec = "update user set phone_number = '".$_POST["phoneNumber"]."', 
						email = '".$_POST["email"]."',
						first_name = '".$_POST["first_name"]."', 
						surname = '".$_POST["surname"]."',
						country = '".$_POST["country"]."',
						city = '".$_POST["city"]."',
						address = '".$_POST["address"]."',
						postcode = '".$_POST["postcode"]."',
						brief = '".$_POST["brief"]."' 
			where username = '".$_POST["username"]."'";
echo $exec;
mysql_set_charset('utf8', $link); 
mysql_query($exec, $link) or die(mysql_error); 
echo "<script type = 'text/javascript'>window.location.href = \"manage.php\";</script>";

mysql_close($link); 

?> 
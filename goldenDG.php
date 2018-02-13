<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>CompanyName - PageName</title>
<meta http-equiv="Content-Language" content="en-us" /> 
<meta http-equiv="imagetoolbar" content="no" />
<meta name="MSSmartTagsPreventParsing" content="true" /> 
<meta name="description" content="Description" />
<meta name="keywords" content="Keywords" /> 
<meta name="author" content="Enlighten Designs" />
<style type="text/css" media="all">@import "css/master.css";</style>
</head>
<body>
<div id="header">  
<?php
	include 'dbconnect.php';
	error_reporting(0); 
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	
	$exec = "SELECT username,nick_name,country,city,brief,DG_points,DG_doc from user
			where role_level = 2 order by DG_points desc limit 0,3";
	$result = mysql_query($exec);
	echo "<table>";
	echo "<tr>";
	while($row = mysql_fetch_array($result)){	
		$headimg = './images/user/'.$row['username'].'/head.jpg';
		$default_headimg = './images/default_head.jpg';
		if (file_exists($headimg)) {
			$tmpimg = $headimg;
		} else {
			$tmpimg = $default_headimg;
		}
	//	echo "<script>alert('".$tmpimg."');</script>";
		echo "<td width=150px><img src=\"".$tmpimg."\" width=\"145\" height=\"145\" border=\"0\"/></td>";
		echo "<td width=150px>";
		echo "<table class=\"nosolidborder\" width=150px>";
		echo "<tr>";
		echo '<td align=center colspan=3><font style=\"font-weight:bold;		
		font-size:12pt;color:orange;\"><a href="driverGuide.php?id=',$row['username'],'" target=\"_parent\">'
		,$row['nick_name'],'</a></font></td>';
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=3>".substr($row['brief'], 0, 60)."</td>";
		echo "</tr>";
	//	echo "<tr><td colspan=3>".$row['DG_doc']."</td></tr>";
		$dgDoc = $row['DG_doc'];
		
	//	strpos("You love php, I love php too!","php");
		echo "<tr>";
		echo "<td width=20px>";
		if(strpos($dgDoc,'FDL')>0){
			echo "<img src=\"./images/jia_icon.gif\" width=\"20\" alt=\"驾照已验证\" title=\"驾照已验证\"/>"; 
		}
		echo "</td>";
		echo "<td width=20px>";
		if(strpos($dgDoc,'DEP')>0){
			echo "<img src=\"./images/ya_icon.gif\" width=\"20\" alt=\"已缴纳押金\" title=\"已缴纳押金\"/>";
		}
		echo "</td>";           
		echo "<td width=20px>";
		if(strpos($dgDoc,'PAP')>0){
			echo "<img src=\"./images/hu_icon.gif\" width=\"20\" alt=\"护照已验证\" title=\"护照已验证\"/>";
		}
		echo "</td>";     
		echo "</tr>";
		echo "</table>";
		echo "</td>";
		echo "</td>";
	}
	echo "</tr>";
	echo "</table>";
?>	
</div> 
</body>
</html>
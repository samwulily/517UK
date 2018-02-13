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
<script type="text/javascript" src="js/ajaxmethod.js"></script>
</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 
<div id="content">  
<h1 align="center">车辆详细信息</h1>

<?php 
	require 'phpmethod/commonMethod.php';
	session_start();
	
	include 'dbconnect.php';
	error_reporting(0); 
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	
	$exec = "select TID,username,transtype,brand,reg_year,reg_code,description,imgfolder 
	from transport where TID = '".$_GET['transID']."'";
//	echo $exec;
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$result = mysql_query($exec);
	
	while($row = mysql_fetch_array($result)){	
		
		echo "<table align=center width=400>";
		echo "<tr>";
		$destination_folder = $row['imgfolder']."/";	//	图片路径 
		echo "<td>车辆图片</td>";
		echo "<td>";
		
		if (is_dir($destination_folder)){
			if ($dh = opendir($destination_folder)){
				echo "<table border=0>";
				echo "<tr>";
				while (($file = readdir($dh)) !== false){
					$tagetfile = $destination_folder.$file;
					if(!is_dir($tagetfile)){
						echo "<td><img src=\"".$tagetfile."\" width=\"100\" height=\"100\">";
					}
				}
				echo "</tr>";
				echo "</table>";
				closedir($dh);
			}
		}
		
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=2>";
		echo "</td>";
		echo "</tr>";
		echo "<input type=\"hidden\" name=\"transID\" id=\"transID\" value=".$row['TID'].">";
		echo "<tr><td width=100>车辆类型</td><td>".$row['transtype']."</td></tr>";
		echo "<tr><td width=100>车辆品牌</td><td>".$row['brand']."</td></tr>";
	//	echo "<tr><td width=100>车牌号码</td><td>".$row['reg_code']."</td></tr>";
		echo "<tr><td width=100>注册年份</td><td>".$row['reg_year']."</td></tr>";
		echo "<tr><td width=100>车辆描述</td><td>".$row['description']."</td></tr>";
		echo "</table>";		
	}
	mysql_close($link); 
?>
</div>	
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
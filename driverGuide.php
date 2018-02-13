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

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 
<div id="content">  
<h1 align="center">司导详细信息</h1>

<?php 
	include 'dbconnect.php';
	error_reporting(0); 
	session_start();
	
	$headimg = './images/user/'.$_GET['id'].'/head.jpg';
	$default_headimg = './images/default_head.jpg';
		
	if (file_exists($headimg)) {
//		echo "The file $headimg exists";
		$tmpimg = $headimg;
	} else {
//		echo "The file $headimg does not exist";
		$tmpimg = $default_headimg;
	}
		
	
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	
	$exec = "select username,nick_name,phone_number,email,country,city,address,
	postcode,url,brief,message from user where username = '".$_GET[id]."'";
//	echo $exec;
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$result = mysql_query($exec);
	while($row = mysql_fetch_array($result)){			
		echo "<table align=center width=600>";
		echo "<tr><td width=100>个人头像</td>";	
		echo "<td><img src=\"".$tmpimg."\" width=\"90\" height=\"100\" border=\"0\"/></td></tr>";
		echo "<tr><td width=100>昵称</td><td>".$row['nick_name']."</td></tr>";
		$dis_phone_number = "登录用户可见";
		$dis_email = "登录用户可见";
		if(isset($_SESSION['username'])){
			$dis_phone_number = $row['phone_number'];
			$dis_email = $row['email'];
		}
		echo "<tr><td width=100>电话号码</td><td>".$dis_phone_number."</td></tr>";
		echo "<tr><td width=100>电子邮件</td><td>".$dis_email."</td></tr>";
		echo "<tr><td width=100>所在国家</td><td>".$row['country']."</td></tr>";
		echo "<tr><td width=100>所在城市</td><td>".$row['city']."</td></tr>"; 
		echo "<tr><td width=100>邮政编码</td><td>".$row['postcode']."</td></tr>";
		echo "<tr><td width=100>自我介绍</td><td>".$row['brief']."</td></tr>";
		echo "</table>";		
	}
	
	$execTrans = "select TID,username,transtype,brand,reg_year,reg_code,description,imgfolder  
	from transport where username = '".$_GET['id']."' order by add_time";
//	echo $execTrans;
	$resultTrans = mysql_query($execTrans);
	echo "<h1 align=\"center\">车辆详细信息</h1>";
	echo "<table align=center width=600>";
	while($rowTrans = mysql_fetch_array($resultTrans)){	
		echo "<tr><td><a href=\"displaytrans.php?username=".$_GET['id']."&transID=".$rowTrans['TID']."\">".$rowTrans[reg_year].$rowTrans['brand']."</a></td></tr>";
//			echo "<tr><td>".$rowTrans[reg_year].$rowTrans['brand']."</td></tr>";
		echo "<tr>";
		$destination_folder = $rowTrans['imgfolder']."/";	//	图片路径 
			echo "<td>";
			
			if (is_dir($destination_folder)){
				if ($dh = opendir($destination_folder)){
					echo "<table border=0>";
					echo "<tr>";
					while (($file = readdir($dh)) !== false){
						$tagetfile = $destination_folder.$file;
						if(!is_dir($tagetfile)){							
							echo "<td><a href=\"showOriginalImg.php?file=".$tagetfile."\" target=\"_blank\">
							<img src=\"".$tagetfile."\" width=\"100\" height=\"100\"></a>";
						}
					}
					echo "</tr>";
					echo "</table>";
					closedir($dh);
				}
			}
			
			echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
	mysql_close($link); 
?>
</div>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>
</div>

</div>  



</body>
</html>


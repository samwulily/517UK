<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>我要去英国网</title>
<meta http-equiv="Content-Language" content="en-us" /> 
<meta http-equiv="imagetoolbar" content="no" />
<meta name="MSSmartTagsPreventParsing" content="true" /> 
<meta name="description" content="去英国" />
<meta name="keywords" content="我要去英国" /> 
<meta name="author" content="Enlighten Designs" />
<style type="text/css" media="all">@import "css/master.css";</style>
</head>
<body>

<?php
	include 'dbconnect.php';
	error_reporting(0); 
	$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
	if(!$link){
		die("connect db failed:".mysql_error());
	}
	mysql_select_db($dbname, $link); 
	
	echo "<table width=630px>";
	
	$dpagesize = 9;	//	每页显示司机记录条数
	$dp = $_GET['dp']?$_GET['dp']:1;	//	//确定页数 dp 参数, _GET 变量有则有，没有则为1
	$doffset = ($dp-1)*$dpagesize;	//	//数据指针
	$col = 0;
	$cols = 3;	//	每行3列
	
	$exec = "select username,nick_name,phone_number,email,country,city,url,brief,message 
	from user where role_level = 2 order by reg_time desc limit $doffset,$dpagesize";
//		echo $exec;
	mysql_query("set character set 'gbk'"); 
	mysql_query("set character set 'utf8'");
	$result = mysql_query($exec);
	while($row = mysql_fetch_array($result)){
		$company_brief_short = substr($row['brief'], 0, 22);
		$coordinator_short = substr($row['nick_name'],0,10);
		$col = $col + 1;
		if ($col%$cols == 1){
			echo "<tr>\n";
		}
		echo "<td width=210px>";
			echo "<table width=210px>";
				echo "<tr>";
					echo "<td width=90px>";
					
					$headimg = './images/user/'.$row['username'].'/head.jpg';
					$default_headimg = './images/default_head.jpg';
					if (file_exists($headimg)) {
				//		echo "The file $headimg exists";
						$tmpimg = $headimg;
					} else {
				//		echo "The file $headimg does not exist";
						$tmpimg = $default_headimg;
					}
						echo "<img src=\"".$tmpimg."\" width=\"90\" height=\"100\" border=\"0\"/>";
					echo "</td>";
					echo "<td>";
						echo "<table class=\"nosolidborder\" width=100px>";
							echo "<tr>";
								echo '<td align=center><font style=\"font-weight:bold;
								font-size:12pt;color:orange;\">
								<a href="driverGuide.php?id=',$row['username'],'" target="_parent">'
								,$coordinator_short,'</a></font></td>';
							echo "</tr>";
							echo "<tr>";
								echo "<td>".$company_brief_short."</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
		if ($col%$cols == 0){
			echo "</tr>";
		} 
	}
	
	if($col%$cols !=0 ) {
		for($i=1; $i<=$cols-$col%$cols; $i++) {
			echo "<td> </td>\n";
		}
	}
	if($i>1) echo "</tr>\n";
	
	echo "</table>";
	
	//计算司机总数
	$dcount_result = mysql_query("SELECT count(*) as count FROM user where role_level=2");
	$dcount_array = mysql_fetch_array($dcount_result);
	//计算总的页数
	$dpagenum=ceil($dcount_array['count']/$dpagesize);
	//循环输出各页数目及连接
	
	if ($dpagenum > 1) {
		for($i=1;$i<=$dpagenum;$i++) {
			if($i==$dp) {
				echo ' [',$i,']';
			} else {
				echo ' <a href="searchDG.php?dp=',$i,'">',$i,'</a>';
			}
		}
	}
	
	mysql_close($link); 
?>
</body>
</html>
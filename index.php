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

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<iframe frameborder=0 width=940px height=150px marginheight=0 marginwidth=0 scrolling= no src="goldenDG.php"></iframe>
<div id="sidebar-a">  
<div class="padding">
	<iframe frameborder=0 width=280px height=130px marginheight=0 marginwidth=0 scrolling= no src="contact_highlight.html"></iframe>	

	<table>
		<tr>
			<td>最新需求</td>
			<td><a href="bookcar.php">所有需求</a></td>
			<td><a href="./yongche/yongche.php">发布需求</a></td>
		</tr>
	</table>
	
	<?php
		session_start();
		echo "<table width=250px>";
		include 'dbconnect.php';
		error_reporting(0); 
		$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
		if(!$link){
			die("connect db failed:".mysql_error());
		}
		mysql_select_db($dbname, $link); 
		$pagesize = 20;	//	每页显示记录条数
		$p = $_GET['p']?$_GET['p']:1;	//	//确定页数 p 参数, _GET 变量有则有，没有则为1
		$offset = ($p-1)*$pagesize;	//	//数据指针
		//查询本页显示的数据
		$exec = "select bookcar.reserveid,bookcar.yongchetype,bookcar.reservedate,
		bookcar.reservetime,bookcar.startAddress,bookcar.destAddress,user.nick_name 
		from bookcar,user 
		where user.username = bookcar.userID 
		order by booktime desc limit $offset , $pagesize";
				
	//	$exec = "select reserveid,yongchetype,reservedate,reservetime,startAddress,
	//	destAddress,userID from bookcar order by booktime desc limit $offset , $pagesize";
				
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		echo "<tr>";
		echo "<td>联系人</td><td>用车时间</td><td>用车类别</td><td></td>";
		echo "</tr>";
		$result = mysql_query($exec);
		while($row = mysql_fetch_array($result)){
			$name = substr($row['nick_name'],0,4);
			echo "<tr>";
			echo "<td width=40px>".$name."</td>";
			echo "<td>".$row['reservedate']."</td>";
			echo "<td>".$row['yongchetype']."</td>";
			echo '<td><a href="bookcar.php?id=',$row['reserveid'],'">',详情,'</a></td>';
			echo "</tr>";
		}
		echo "</table>";
		//计算留言总数
		$count_result = mysql_query("SELECT count(*) as count FROM bookcar");
		$count_array = mysql_fetch_array($count_result);
		//计算总的页数
		$pagenum=ceil($count_array['count']/$pagesize);
		//循环输出各页数目及连接
		
		if ($pagenum > 1) {
			for($i=1;$i<=$pagenum;$i++) {
				if($i==$p) {
					echo ' [',$i,']';
				} else {
					echo ' <a href="index.php?p=',$i,'">',$i,'</a>';
				}
			}
		}

		
	?>
	
	
</div>  
</div>  
<div id="content">  
<div class="padding">
  <h2><a href="searchDG.php" target="DriverGuide">加盟司机</a></h2>
  
	<?php
		$dp = $_GET['dp']?$_GET['dp']:1;	//确定司导页数 dp 参数, _GET 变量有则有，没有则为1
	?>
	<iframe frameborder=0 width=660px height=400px marginheight=0 marginwidth=0 name="DriverGuide" scrolling= yes src="searchDG.php?dp=<?php echo $dp?>"></iframe>		
  
  <h2><a href="searchUser.php" target="User">注册用户</a></h2>  
	<iframe frameborder=0 width=660px height=400px marginheight=0 marginwidth=0 name="User" scrolling= yes src="searchUser.php?dp=<?php echo $dp?>"></iframe>

</div>  
</div>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>
</div>

</div>  

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/59f998a2bb0c3f433d4c6413/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


</body>
</html>


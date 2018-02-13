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
<script type="text/javascript">

</script>

</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<iframe frameborder=0 width=940px height=150px marginheight=0 marginwidth=0 scrolling= no src="header.html"></iframe>
<div id="sidebar-a">  

</div>  
<div id="content">  
<div class="padding">

<h2>现有车辆</h2>

<?php
	require 'phpmethod/commonMethod.php';
	session_start();
	if(isset($_SESSION['nick_name'])){
		include 'dbconnect.php';
		error_reporting(0); 
		$link =mysql_connect($dbserver,$dbuser,$dbpwd);   
		if(!$link){
			die("connect db failed:".mysql_error());
		}
		mysql_select_db($dbname, $link); 
		$exec = "select TID,username,transtype,brand,reg_year,reg_code,description,imgfolder  
		from transport where username = '".$_GET['username']."' order by add_time";
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		$result = mysql_query($exec);
		
		echo "<table>";
		while($row = mysql_fetch_array($result)){	
			echo "<tr><td><a href=\"gettrans.php?username=".$_GET['username']."&transID=".$row['TID']."\">".$row[reg_year].$row['brand']."</a></td></tr>";
			echo "<tr>";
			$destination_folder = $row['imgfolder']."/";	//	图片路径 
			echo "<td>";
			showimage($destination_folder);
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";		
		mysql_close($link); 
		
	}else{
		echo "<script>alert(\"请登录!\");</script>";
		echo "<script>window.location.href = \"login.html\"</script>";
	}
?>
 
<h2>增加车辆（打<font color="red" size=5>*</font>部分为必填部分）</h2>
  <p>
  
	<table>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<form action="add_trans_info.php" method="post" onsubmit="return validate_form(this)">
		<input type="hidden" name="username" id="username" value="<?php echo $_GET['username'] ?>">
		<tr>
			<td>车辆类型：</td>
			<td>
				<select name="transtype" id="transtype">
					<option value="4座位小型轿车" selected>4座位小型轿车</option>
					<option value="5座位中型轿车">5座位中型轿车</option>
					<option value="7座位大型轿车">7座位大型轿车</option>
					<option value="9座位超大型轿车">9座位超大型轿车</option>
					<option value="17座客车">17座客车</option>
					<option value="小型货车">小型货车</option>
					<option value="中型货车">中型货车</option>
					<option value="大型货车">大型货车</option>
					<option value="超大型货车">超大型货车</option>
					<option value="超大型货车（带尾部升降台）">超大型货车（带尾部升降台）</option>
				</select> 
			</td>
		</tr>
		<tr>
			<td>车辆品牌：</td>
			<td><input type="text" name="brand" id="brand" size="51"></td>
		</tr>
		<tr>
			<td>车牌号码：</td>
			<td><input type="text" name="reg_code" id="reg_code" size="51"></td>
		</tr>
		<tr>
			<td>注册年份：</td>
			<td>
				<select name="reg_year" id="reg_year">
					<?php 
						for($i=2005;$i<=2015;$i++){
							echo "<option value=\"".$i."\" selected>".$i."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>车辆描述：</td>
			<td><textarea name="description" id="description" rows="4" cols="40"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="提交"><input type="reset" value="重写"></td>
		</tr>
		</form>
	
	</table>
 
  </p>
 
 
 
</div>  
</div>
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>   
</div>

</div>  



</body>
</html>


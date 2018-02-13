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
<script type="text/javascript">
function changeyanzhengma()
{
	alert("改变验证码");
	document.getElementById("yanzhengma").src='tupianyanzhengma.php';
	alert("改变完毕");
}
</script>
</head>
<body>

<div id="page-container">  
	<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
	<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
	<iframe frameborder=0 width=940px height=150px marginheight=0 marginwidth=0 scrolling= no src="header.html"></iframe>
	<h1>找回密码</h1>
	<h2>请输入您注册时填写的邮箱地址，我们将发送密码找回邮件到您的注册邮箱。</h2>
	<form action="verify_user_submit.php" method="post">
	<table>
		<tr>
			<td>Email：</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>验证码：</td>
			<td><input type="text" name="yzm"></td>
		</tr>
		<tr>
			<td></td>
			<td>输入下图中的字符</td>
		</tr>
		<tr>
			<td><a href=# onclick="yanzhengma.src='tupianyanzhengma.php?t='+(new Date().getTime());return false;">看不清楚,换一张</a></td>
			<td><img src="tupianyanzhengma.php" name="yanzhengma" id="yanzhengma"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="提交"></td>
		</tr>
	</table>
	</form>
	<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>
</div>

</body>
</html>


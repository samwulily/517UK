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
<link href="css/style.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="js/ajaxmethod.js"></script>
<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/jquery.form.js'></script>
<script type="text/javascript">

function checkfilesize(){  
	reMsg = "OK";
	try{  
		var maxsize = 300*1024;//300K
		var errMsg = "上传的附件文件不能超过300K！！！";  
		var tipMsg = "您的浏览器暂不支持计算上传文件的大小，确保上传文件不要超过300K，建议使用IE、FireFox、Chrome浏览器。";  
		var  browserCfg = {};  
		var ua = window.navigator.userAgent;  

		if (ua.indexOf("MSIE")>=1){  
			browserCfg.ie = true;  
		}else if(ua.indexOf("MSIE 6.0")>=1){
			browserCfg.ie6 = true;
		}else if(ua.indexOf("Firefox")>=1){  
			browserCfg.firefox = true;  
		}else if(ua.indexOf("Chrome")>=1){  
			browserCfg.chrome = true;  
		}  
		var obj_file = document.getElementById("upfile");  
		if(obj_file.value==""){  
			reMsg = "请先选择上传文件";
			alert(reMsg);  
			return reMsg;  
		}  
		var filesize = 0;  
		if(browserCfg.firefox || browserCfg.chrome ){  
			filesize = obj_file.files[0].size;  
		}else if(browserCfg.ie||browserCfg.ie6){  
			var obj_img = document.getElementById('tempimg');  
			obj_img.dynsrc=obj_file.value;  
			filesize = obj_img.fileSize;  
		}else{  
			reMsg = tipMsg;
			alert(reMsg);  
			return reMsg;  
		}  
		if(filesize==-1){  
			reMsg = tipMsg;
			alert(reMsg);  
			return reMsg;  
		}else if(filesize>maxsize){  
			reMsg = errMsg;
			alert(reMsg);  
			return reMsg;  
		}else{  
			reMsg = "OK";
			return reMsg;  
		}  
	}catch(e){ 
		alert(e);
		return "异常抛出";
	}  
	return reMsg;
}  
		
$(document).ready(function(e) {
	var progress = $(".progress"); 
   var progress_bar = $(".progress-bar");
   var percent = $('.percent');
	$("#upload").click(function(){
		
		var file = document.getElementById("upfile");
		var ext=file.value.substring(file.value.lastIndexOf(".")+1).toLowerCase();
		// gif在IE浏览器暂时无法显示
		if(ext!='png'&&ext!='jpg'&&ext!='jpeg'){
			alert("图片的格式必须为png或者jpg或者jpeg格式！"); 
			return;
		}
		var re = checkfilesize();
		if(re!= "OK"){
			return;
		}
		$("#idimage").ajaxSubmit({ 
				
  		dataType:  'json', //数据格式为json 
  		beforeSend: function() { //开始上传 
  			progress.show();
  			var percentVal = '0%';
  			progress_bar.width(percentVal);
  			percent.html(percentVal);
  		}, 
  		uploadProgress: function(event, position, total, percentComplete) { 
  			var percentVal = percentComplete + '%'; //获得进度 
  			progress_bar.width(percentVal); //上传进度条宽度变宽 
  			percent.html(percentVal); //显示上传进度百分比 
  		}, 
  		success: function(data) {
			alert(data.content);
			progress.hide();		 
  		}, 
		error:function(xhr,textStatus,errorThrown){
  		   alert("上传失败");
		   alert("readyState:"+xhr.readyState + " status:"+xhr.status + " statusText:"+xhr.statusText+" responseText:"+xhr.responseText);
		   alert("textStatus:"+textStatus+" errorThrown:"+errorThrown);
  		   progress.hide(); 
  		} 	
  	}); 
   });

});

function idimageChange() {
	var pic = document.getElementById("idpreview");
	var file = document.getElementById("upfile");

	var ext=file.value.substring(file.value.lastIndexOf(".")+1).toLowerCase();
	
	// gif在IE浏览器暂时无法显示
//     if(ext!='png'&&ext!='jpg'&&ext!='jpeg'){
	if(ext!='jpg'){
		alert("图片的格式必须为jpg格式！"); 
		return;
     }
	 var isIE = navigator.userAgent.match(/MSIE/)!= null,
		 isIE6 = navigator.userAgent.match(/MSIE 6.0/)!= null;

	 if(isIE) {
		file.select();
		var reallocalpath = document.selection.createRange().text;

		// IE6浏览器设置img的src为本地路径可以直接显示图片
         if (isIE6) {
			pic.src = reallocalpath;
		 }else {
			// 非IE6版本的IE由于安全问题直接设置img的src无法显示本地图片，但是可以通过滤镜来实现
             pic.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='image',src=\"" + reallocalpath + "\")";
             // 设置img的src为base64编码的透明图片 取消显示浏览器默认图片
             pic.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
		 }
	 }else {
		html5Reader(file);
	 }
}

 function html5Reader(file){
     var file = file.files[0];
     var reader = new FileReader();
     reader.readAsDataURL(file);
     reader.onload = function(e){
         var pic = document.getElementById("idpreview");
         pic.src=this.result;
     }
 }
 
// function submitImage(file){
//	 var imgform = document.getElementById("idimage");
//	 alert("file:"+file);
	 
//	 imgform.submit();
 //}
 </script>
</head>
<body>

<div id="page-container">  
<iframe frameborder=0 width=940px height=30px marginheight=0 marginwidth=0 scrolling= no src="login_reg_nav.php"></iframe>
<iframe frameborder=0 width=940px height=36px marginheight=0 marginwidth=0 scrolling= no src="nav.html"></iframe>
<div id="header">  
<h1><img src="images/general/logo_yingjie.jpg"    
width="236" height="36" alt="Ying Jie consultant" border="0" /></h1>  
</div> 

<div id="sidebar-b">  
<div class="padding">
<iframe frameborder=0 width=120px height=200px marginheight=0 marginwidth=0 scrolling= no src="usr_center.php"></iframe>	
</div>
</div>	

<div id="content_a">  
<div class="padding">
<h1 align="center">用户详细信息</h1>

<?php 
	session_start();

	$headimg = './images/user/'.$_GET['id'].'/head.jpg';
	$headtmpimg = './images/user/'.$_GET['id'].'/headtmp.jpg';
	$default_headimg = './images/default_head.JPG';
	
	
	if (file_exists($headimg)) {
//		echo "The file $headimg exists";
		$tmpimg = $headimg;
	} else {
//		echo "The file $headimg does not exist";
		$tmpimg = $default_headimg;
	}
	
	if(isset($_SESSION['nick_name'])){
		include 'dbconnect.php';
		error_reporting(0); 
		$link =mysql_connect($dbserver,$dbuser,$dbpwd); 
		if(!$link){
			die("connect db failed:".mysql_error());
		}
		mysql_select_db($dbname, $link); 
		$exec = "select username,nick_name,phone_number,email,first_name,surname,country,city,
		address,postcode,brief from user where username='".$_GET['id']."'";
	//	echo $exec;
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		$result = mysql_query($exec);
		
		
		while($row = mysql_fetch_array($result)){	
			
			echo "<table align=center width=600 border=0>";
			echo "<tr><td width=100>个人头像</td>";	
			
			echo "<td><img id=\"idpreview\" name=\"idpreview\" src=\"".$tmpimg."\" width=\"90\" height=\"100\" border=\"0\"/></td></tr>";
	?>
			<tr>
				<td></td>
				<td>
					<div class="progress">
						<div class="progress-bar progress-bar-striped" ><span class="percent">0%</span></div>
					</div>
				</td>
			</tr>
				
			<tr>
			<form action="uploadheadpic.php?username=<?php echo $_GET['id']?>"
			enctype = "multipart/form-data" method="post" name="idimage" id="idimage" target="idimage_result">
			<td colspan="2">
				<img id="tempimg" dynsrc="" src="" style="display:none" />  
				<input name="upfile" id="upfile" type="file" onchange="idimageChange()">  
				<input type="button" id="upload" name="upload" value="上传照片" />
			</td>
			</form>
			</tr>
			<tr>
			<td colspan="2">允许上传的文件类型为: JPG
			<iframe id = "idimage_result" name = "idimage_result" style="" frameborder=0
width=300px height=50px marginheight=0 marginwidth=0></iframe>
			</td>
			</tr>

	<?php
			
			echo "<form action=\"updateuser.php\" method=\"post\">";
			echo "<tr><td colspan=\"2\"><h2>必填</h2></td></tr>";
			echo "<tr><td width=100>用户名</td><td><input type=\"text\" id=\"username\" 
				name=\"username\" size=\"43.5\" value=\"".$row['username']."\" readonly=\"readonly\">
				</td></tr>";
			echo "<tr><td width=100>昵称</td><td>".$row['nick_name']."</td></tr>";
			echo "<tr><td width=100>电话号码</td><td><input type=\"text\" id=\"phoneNumber\" 
				name=\"phoneNumber\" size=\"43.5\" value=\"".$row['phone_number']."\"></td></tr>";
			echo "<tr><td width=100>电子邮件</td><td><input type=\"text\" id=\"email\"
				name=\"email\" size=\"43.5\" value=\"".$row['email']."\" readonly=\"readonly\">
				</td></tr>";
			echo "<tr><td colspan=\"2\"><h2>可选</h2></td></tr>";
			
			echo "<tr><td width=100>名字</td><td><input type=\"text\" id=\"first_name\"
				name=\"first_name\" size=\"43.5\" value=\"".$row['first_name']."\"></td></tr>";
			echo "<tr><td width=100>姓</td><td><input type=\"text\" id=\"surname\"
				name=\"surname\" size=\"43.5\" value=\"".$row['surname']."\"></td></tr>";	
			echo "<tr><td width=100>所在国家</td><td><input type=\"text\" id=\"country\"
				name=\"country\" size=\"43.5\" value=\"".$row['country']."\"></td></tr>";
			echo "<tr><td width=100>所在城市</td><td><input type=\"text\" id=\"city\"
				name=\"city\" size=\"43.5\" value=\"".$row['city']."\"></td></tr>";
			echo "<tr><td width=100>详细地址</td><td><input type=\"text\" id=\"address\"
				name=\"address\" size=\"43.5\" value=\"".$row['address']."\"></td></tr>";
			echo "<tr><td width=100>邮政编码</td><td><input type=\"text\" id=\"postcode\"
				name=\"postcode\" size=\"43.5\" value=\"".$row['postcode']."\"></td></tr>";
			echo "<tr><td width=100>自我介绍</td><td><textarea id=\"brief\" 
				name=\"brief\" rows=\"4\" cols=\"40\">".$row['brief']."</textarea></td></tr>";
			echo "<tr><td></td><td><input type=\"submit\" value=\"更新\"></td></tr>";
			echo "</form>";
			echo "</table>";		
		}
		mysql_close($link); 
		
	}else{
		echo "<script>alert(\"请登录!\");</script>";
		echo "<script>window.location.href = \"login.html\"</script>";
	}
?>
</div>	
</div>	
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
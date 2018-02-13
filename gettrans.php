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
			window.location.reload();
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

function picChange() {
	var pic = document.getElementById("picpreview");
	var file = document.getElementById("upfile");

	var ext=file.value.substring(file.value.lastIndexOf(".")+1).toLowerCase();
	
	// gif在IE浏览器暂时无法显示
     if(ext!='png'&&ext!='jpg'&&ext!='jpeg'){
         alert("图片的格式必须为png或者jpg或者jpeg格式！"); 
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
         var pic = document.getElementById("picpreview");
		 pic.style.display = "";
         pic.src=this.result;
     }
 }
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
<div id="content">  
<h1 align="center">车辆详细信息</h1>

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
		from transport where TID = '".$_GET['transID']."'";
	//	echo $exec;
		mysql_query("set character set 'gbk'"); 
		mysql_query("set character set 'utf8'");
		$result = mysql_query($exec);
		
		while($row = mysql_fetch_array($result)){	
			
			echo "<table align=center width=400 border=0>";
			echo "<tr>";
			$destination_folder = $row['imgfolder']."/";	//	图片路径 
			echo "<td>车辆图片</td>";
			echo "<td>";
			showimage($destination_folder);
			echo "</td>";
			echo "</tr>";			
	?>
	
			<form action="uploadtranspic.php?foldername=<?php echo $row['imgfolder']."/"?>&filename=<?php echo $row['reg_code'].time() ?>"
			enctype = "multipart/form-data" method="post" name="idimage" id="idimage" target="idimage_result">
			<tr>
				<td colspan="2">
					<img id="tempimg" dynsrc="" src="" style="display:none" />  
					<input name="upfile" id="upfile" type="file" onchange="picChange()">
					<input type="button" id="upload" name="upload" value="上传照片" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					允许上传的文件类型为: JPG,PNG	
					<img id="picpreview" name="picpreview" src="" width="90" height="100" border="0" style="display:none"/>
					<iframe id = "idimage_result" name = "idimage_result" style="" frameborder=0 
		width=200px height=50px marginheight=0 marginwidth=0></iframe>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="progress">
						<div class="progress-bar progress-bar-striped" ><span class="percent">0%</span></div>
					</div>
				</td>
			</tr>
			</form>
			
			<?php
			
			echo "</tr>";
			echo "<form action=\"updatetrans.php\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"transID\" id=\"transID\" value=".$row['TID'].">";
			echo "<tr><td width=100>车辆类型</td><td>".$row['transtype']."</td></tr>";
			echo "<tr><td width=100>车辆品牌</td><td>".$row['brand']."</td></tr>";
			echo "<tr><td width=100>车牌号码</td><td>".$row['reg_code']."</td></tr>";
			echo "<tr><td width=100>注册年份</td><td>".$row['reg_year']."</td></tr>";
			echo "<tr><td width=100>车辆描述</td><td><textarea id=\"desc\" 
				name = \"desc\" rows = \"4\" cols = \"40\">".$row['description']."</textarea></td></tr>";
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
<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>

</div>

</body>
</html>
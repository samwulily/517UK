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
<iframe frameborder=0 width=940px height=150px marginheight=0 marginwidth=0 scrolling= no src="header.html"></iframe>
<div id="sidebar-a">  

</div>  

<div class="padding">

  <h2>我的图片<h2>
  <p>
  <form action="add_picture.php?username=<?php echo $_GET['username']?>" 
	enctype="multipart/form-data" method="post" name="upform" id="upform" target="uploadfile_result">  
	  上传文件:  
	  <input name="upfile" type="file">  
	  <input type="submit" id="upload" name="upload" value="上传" /><br>  
	  允许上传的文件类型为: JPG,PNG
  </form>  
  </p>
  <?php
	require 'phpmethod/commonMethod.php';
	$destination_folder = "images/user/".$_GET['username']."/";	//	文件路径 
	showimage($destination_folder);
  ?>
<!--add_picture.php页面返回的数据 显示在iframe 中-->
<iframe id = "uploadfile_result" name = "uploadfile_result" style="" frameborder=0 
width=500px height=50px marginheight=0 marginwidth=0></iframe>
</div>

<iframe frameborder=0 width=940px height=66px marginheight=0 marginwidth=0 scrolling= no src="footer.html"></iframe>   
</div>

</div>  



</body>
</html>


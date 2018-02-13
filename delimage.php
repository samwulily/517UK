<?php
	$file = $_GET['filename'];
	echo $file;
	if (!unlink($file)){
		echo ("$file 删除失败！");
	}else{
		echo ("$file 删除成功！");
	}
?>
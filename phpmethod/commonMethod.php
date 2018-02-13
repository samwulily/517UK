<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php

$Globe_order_status = array
(
  array(0,"等待","blue"),
  array(1,"成交","green"),
  array(2,"取消","black"),
  array(3,"流单","red")
);

$Globe_pay_status = array
(
	array(0,"未付款","red"),
	array(1,"已付款","green")
);


function getOrderStatus($status){
	global $Globe_order_status;
	return $Globe_order_status[$status][1];
}

function getOrderStatusColor($status){
	global $Globe_order_status;
	return $Globe_order_status[$status][2];
}

function getPayStatus($pay_status){
	global $Globe_pay_status;
	return $Globe_pay_status[$pay_status][1];
}

function getPayStatusColor($pay_status){
	global $Globe_pay_status;
	return $Globe_pay_status[$pay_status][2];
}

function showimage($destination_folder){
//	$destination_folder = "images/user/".$_GET['username']."/";	//	上传文件路径 
			
	
	// Open a directory, and read its contents
	if (is_dir($destination_folder)){
		if ($dh = opendir($destination_folder)){
			echo "<table border=0>";
			echo "<tr>";
			while (($file = readdir($dh)) !== false){
				$tagetfile = $destination_folder.$file;
				if(!is_dir($tagetfile)){
					echo "<td><img src=\"".$tagetfile."\" width=\"100\" height=\"100\">";
					echo "<button onclick=\"delFile('".$tagetfile."')\">删除</button></td>";
				}
			}
			
			echo "</tr>";
			echo "</table>";
			closedir($dh);
		}
	}
}	

function getImgNum($folder){
	$num = 0;
	if(is_dir($folder)){
		if($dh = opendir($folder)){
			while(false!==($file = readdir($dh))){
				$tagetfile = $folder.$file;
				if(!is_dir($tagetfile)){
					$num++;
				}
			}
			closedir($dh);
		}
	}
	return $num;
}

function uploadimage($dest_folder,$uploadfile){

	$uptypes=array(  
		'image/jpg',  
		'image/jpeg',  
		'image/png',  
		'image/pjpeg',  
		'image/gif',  
		'image/bmp',  
		'image/x-png'  
	);  
	  
	//$max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
	  $max_file_size=2097152;     //上传文件大小限制, 单位BYTE,这里是2M
	//$dest_folder="uploadimg/"; //上传文件路径  
//	$dest_folder = "images/user/".$_GET['username']."/";	//	上传文件路径 
	$watermark=1;      //是否附加水印(1为加水印,其他为不加水印);  
	$watertype=1;      //水印类型(1为文字,2为图片)  
	$waterposition=5;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
	$waterstring="http://www.517yingguo.cn/";  //水印字符串  
	$waterimg="xplore.gif";    //水印图片  
	$imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
	$imgpreviewsize=1/2;    //缩略图比例  

	if ($_SERVER['REQUEST_METHOD'] == 'POST')  
	{  
		if (!is_uploaded_file($_FILES["upfile"]["tmp_name"])){	//是否存在文件  
			 echo "图片不存在!";  
			 exit;  
		}  
		$file = $_FILES["upfile"];  
		if($max_file_size < $file["size"]){	//检查文件大小 
			echo "文件太大!";  
			exit;  
		}  
		if(!in_array($file["type"], $uptypes)){   //检查文件类型  
			echo "文件类型不符!".$file["type"];  
			exit;  
		}  
		if(!file_exists($dest_folder)){  
			mkdir($dest_folder);  
		}  
	  
		$filename=$file["tmp_name"];  
		$image_size = getimagesize($filename);  
		$pinfo=pathinfo($file["name"]);  
		$ftype=$pinfo['extension'];  
//		$destination = $dest_folder.time().".".$ftype;  
		$destination = $dest_folder.$uploadfile.".".$ftype;  
//		if (file_exists($destination) && $overwrite != true){  
//			echo "同名文件已经存在了";  
//			exit;  
//		}  
		if(!move_uploaded_file ($filename, $destination)){  
			echo "移动文件出错";  
			exit;  
		}  
	  
		$pinfo=pathinfo($destination);  
		$fname=$pinfo['basename'];  
	//	$fname=$pinfo;  
	//    echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$dest_folder.$fname."</font><br>";  
	//    echo " 宽度:".$image_size[0];  
	//    echo " 长度:".$image_size[1];  
	//    echo "<br> 大小:".$file["size"]." bytes";  
	  
		if($watermark==1)  
		{  
			$iinfo=getimagesize($destination,$iinfo);  
			$nimage=imagecreatetruecolor($image_size[0],$image_size[1]);  
			$white=imagecolorallocate($nimage,255,255,255);  
			$black=imagecolorallocate($nimage,0,0,0);  
			$red=imagecolorallocate($nimage,255,0,0);  
			imagefill($nimage,0,0,$white);  
			switch ($iinfo[2])  
			{  
				case 1:  
				$simage =imagecreatefromgif($destination);  
				break;  
				case 2:  
				$simage =imagecreatefromjpeg($destination);  
				break;  
				case 3:  
				$simage =imagecreatefrompng($destination);  
				break;  
				case 6:  
				$simage =imagecreatefromwbmp($destination);  
				break;  
				default:  
				die("不支持的文件类型");  
				exit;  
			}  
	  
			imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);  
			imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);  
	  
			switch($watertype)  
			{  
				case 1:   //加水印字符串  
				imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);  
				break;  
				case 2:   //加水印图片  
				$simage1 =imagecreatefromgif("xplore.gif");  
				imagecopy($nimage,$simage1,0,0,0,0,85,15);  
				imagedestroy($simage1);  
				break;  
			}  
	  
			switch ($iinfo[2])  
			{  
				case 1:  
				//imagegif($nimage, $destination);  
				imagejpeg($nimage, $destination);  
				break;  
				case 2:  
				imagejpeg($nimage, $destination);  
				break;  
				case 3:  
				imagepng($nimage, $destination);  
				break;  
				case 6:  
				imagewbmp($nimage, $destination);  
				//imagejpeg($nimage, $destination);  
				break;  
			}  
	  
			//覆盖原上传文件  
			imagedestroy($nimage);  
			imagedestroy($simage);  
		}  
	}  
	echo "图片上传成功！";
}

// 说明：获取完整URL
function curPageURL() 
{
    $pageURL = 'http';

	if(isset($_SERVER['HTTPS'])) {
		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
	}
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80") 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } 
    else 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
	
function getGBPCNYRateFromWeb(&$rate)	// 从网上抓取汇率
{
	$from_Currency="GBP";  
    $to_Currency="CNY";  
    
	$return_msg = "OK";
		
    $from_Currency = urlencode($from_Currency);  
    $to_Currency = urlencode($to_Currency);  
    $url="http://api.k780.com:88/?app=finance.rate&scur=".$from_Currency."&tcur=".$to_Currency."&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json";  
    $ch = curl_init();  
    $timeout = 0;  
    curl_setopt ($ch, CURLOPT_URL, $url);  
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");  
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
    $rawdata = curl_exec($ch);  
    curl_close($ch);  
    if(!empty($rawdata)){  						//	返回字符串不为空
        $re_arr=json_decode($rawdata,true);  
		if(NULL != $re_arr){					//	返回字符串符合json格式
			$success = $re_arr["success"];
			if(1 == $success){					//	success 值 = 1
				$rate = $re_arr["result"]["rate"];
			}else{
				$return_msg = "success字段不是1";
			}
		}else{
			$return_msg = "从k780.com返回的字符串不符合json格式！";
		}
    }else{  
        $return_msg = "从k780.com返回的字符串为空。";
    }
	return $return_msg;
}	

function get_time_interval($link)
{
	$interval = 3600;	//	如果数据库没有值，默认1小时
	$getInterval = "select value from comm where name = 'interval'";
	$intervalRes = mysql_query($getInterval,$link);
	while($intervalRow = mysql_fetch_array($intervalRes)){
		$interval = $intervalRow['value'];
	}
	return $interval;
}
 
function getGBPCNYRate($link,&$rate,&$update_time)
{
	$getRate = "select value,time from comm where name = 'GBPCNYRate'";
	$rateRes = mysql_query($getRate,$link);
	while($rateRow = mysql_fetch_array($rateRes)){
		$rate 		 = $rateRow['value'];
		$update_time = $rateRow['time'];
		$update_time_stamp = strtotime($update_time);
	}	
	$current_time = date("Y-m-d H:i:s");	//	H 是 24小时制 h 是 12小时制
	
//	echo "当前时间是：".$current_time."<br>";
	$currentTimeStamp = strtotime($current_time);
	$time_interval = $currentTimeStamp - $update_time_stamp;	//	取得当前时间和汇率更新时间差
	$interval = get_time_interval($link);
//	echo "时间间隔：".$interval."<br>";
//	echo "当前时间和更新时间差：".$time_interval;
	if($rate == ""||$time_interval > $interval){	//	如果数据库里没有汇率值或者数值太旧，取新值并更新数据库
//		date_default_timezone_set("Asia/Shanghai"); 
		$msg = getGBPCNYRateFromWeb($rate);
		if(0 == strcmp($msg,"OK")){	//	判断getGBPCNYRateFromWeb返回值，如果返回值不是“OK”，说明有错
			$rate = $rate + 0.18;
			$rate = round($rate,2);
			$update_time = date("Y-m-d H:i:s");
			
			$updatecurRate = "update comm set value = '".$rate."',time = '".$update_time."' where name = 'GBPCNYRate'";
			mysql_set_charset('utf8', $link); 
			mysql_query($updatecurRate, $link) or die(mysql_error); 
		}		
	}
}

function get_unpaid_order_num($link,$usrID,&$num)
{
	$msg = "OK";
	$getnum = "select count(*) as num from bookcar where userID = '".$usrID."' and pay_status = 0";
//	echo $getnum;
	$numRes = mysql_query($getnum,$link);
	while($numRow = mysql_fetch_array($numRes)){
		$num = $numRow['num'];
//		echo "++++unpaid order number:".$num;
	}	
//	echo "unpaid order num:".$num;
	return $msg;
}
	
function get_waiting_order_num($link,$usrID,&$num)
{
	$msg = "OK";
	$getnum = "select count(*) as num from bookcar where userID = '".$usrID."' and status = 0";
//	echo $getnum;
	$numRes = mysql_query($getnum,$link);
	while($numRow = mysql_fetch_array($numRes)){
		$num = $numRow['num'];
//		echo "++++unpaid order number:".$num;
	}	
//	echo "unpaid order num:".$num;
	return $msg;
}	

function get_waiting_feedbackpass2dg_num($link,$usrID,&$num)
{
	$msg = "OK";
	$getnum = "select count(*) as num from bookcar 
				where userID = '".$usrID."' 
				and status = 1 
				and feedback_pass2dg = '' ";
//	echo $getnum;
	$numRes = mysql_query($getnum,$link);
	while($numRow = mysql_fetch_array($numRes)){
		$num = $numRow['num'];
//		echo "++++unpaid order number:".$num;
	}	
//	echo "unpaid order num:".$num;
	return $msg;
}	

function getFeedbackStatus($f_p2dg,$f_dg2p,&$f_status)	
{
	$msg = "OK";
	if($f_p2dg != "")	//	乘客已评
	{
		if($f_dg2p != "")	//	司导已评
		{
			$f_status = "双方已评";
		}else 
		{
			$f_status = "乘客已评";
		}
	}else	//	乘客未评
	{
		if($f_dg2p == "")	//	司导未评
		{
			$f_status = "双方未评";
		}else
		{
			$f_status = "司导已评";
		}
	}
	return $msg;
}
	
function getRoleLevel($link,$username,&$role_level)
{
	$msg = "OK";
	$execgetUser = "select role_level from user where username='".$username."'";
	$userresult = mysql_query($execgetUser,$link);
	while($userrow = mysql_fetch_array($userresult)){	
		$role_level = $userrow['role_level'];
	}	
	return $msg;
}	

	
?>
</body>
</html>
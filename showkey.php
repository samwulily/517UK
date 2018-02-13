<?php
session_start();
// set cookie or session
function esetcookie($name,$str,$life=0){
//	this function transfer string $str to lowcase, so the input verify code are not case sensitive---
//	after submit need use this function to transfer string to lowcase and compare with session
	$_SESSION[$name] = strtolower($str);
}

//	get random charactor, this function is case sensitive, if don't want case sensitive, please add function strtolower
function domake_password($len)
{
	$chars = array(
		/*"a","b","c","d","e","f","g","h","i","j","k",
		"l","m","n","o","p","q","r","s","t","u","v",
		"w","x","y","z","A","B","C","D","E","F","G",
		"H","I","J","K","L","M","N","O","P","Q","R",
		"S","T","U","V","W","X","Y","Z",*/"0","1","2",
		"3","4","5","6","7","8","9"
	);
	$charsLen = count($chars) - 1;
	shuffle($chars);	//	disrupt array order
	$output = "";
	for($i=0;$i<$len;$i++){
		$output = $chars[mt_rand(0,$charsLen)];	//	get an array item
	}
	return $output;
}

//	display verify code
function ShowKey(){
	$key = domake_password(4);	//	get random word
	$set = esetcookie("checkkey",$key);	//	write random word into cookie or session
	//	whether support GD library
	if(function_exists("imagejpeg"))
	{
		header("Content-type: image/jpeg");
		$img = imagecreate(47,20);
		$blue = imagecolorallocate($img,102,102,102);
		$white = imagecolorallocate($img,255,255,255);
		$black = imagecolorallocate($img,71,71,71);
		imagefill($img,0,0,$bule);
		imagestring($img,5,6,3,$key,$white);
		for($i=0;$i<90;$i++)	//	add Interference pixels
		{
			imagesetpixel($img,rand()%70,rand()%30,$black);
		}
		imagejpeg($img);
		imagedestroy($img);
	}
	elseif(function_exists("imagepng"))
	{
		header("Content-type: image/png");
		$img = imagecreate(47,20);
		$blue = imagecolorallocate($img,102,102,102);
		$white = imagecolorallocate($img,255,255,255);
		$black = imagecolorallocate($img,71,71,71);
		imagefill($img,0,0,$blue);
		imagestring($img,5,6,3,$key,$white);
		for($i=0;$i<90;$i++)	//	add Interference pixels
		{
			imagesetpixel($img,rand()%70,rand()%30,$black);
		}
		imagepng($img);
		imagedestroy($img);
	}
	elseif(function_exists("imagegif"))
	{
		header("Content-type: image/gif");
		$img = imagecreate(47,20);
		$blue = imagecolorallocate($img,102,102,102);
		$white = imagecolorallocate($img,255,255,255);
		$black = imagecolorallocate($img,71,71,71);
		imagefill($img,0,0,$blue);
		imagestring($img,5,6,3,$key,$white);
		for($i=0;$i<90;$i++)	//	add Interference pixels
		{
			imagesetpixel($img,rand()%70,rand()%30,$black);
		}
		imagegif($img);
		imagedestroy($img);
	}
	elseif(function_exists("imagewbmp"))
	{
		header("Content-type: image/vnd.wap.wbmp");
		$img = imagecreate(47,20);
		$blue = imagecolorallocate($img,102,102,102);
		$white = imagecolorallocate($img,255,255,255);
		$black = imagecolorallocate($img,71,71,71);
		imagefill($img,0,0,$blue);
		imagestring($img,5,6,3,$key,$white);
		for($i=0;$i<90;$i++)
		{
			imagesetpixel($img,rand()%70,rand()%30,$black);
		}
		imagewbmp($img);
		imagedestroy($img);
	}else{
		//	don't support verify code
		header("content-type:image/jpeg\r\n");
		header("Pragma:no-cache\r\n");
		header("Cache-Control:no-cache\r\n");
		header("Expires:0\r\n");
		$fp = fopen("data/vdcode.jgp","r");
	}
}
ShowKey();
?>

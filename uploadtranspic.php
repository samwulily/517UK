
<?php  

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

function uploadimage_trans($dest_folder,$uploadfile){
	
	$uptypes=array(  
		'image/jpg',  
		'image/jpeg',  
		'image/png',  
		'image/pjpeg',  
		'image/gif',  
		'image/bmp',  
		'image/x-png'  
	);  
	  
	$max_file_size=307200;     //上传文件大小限制, 单位BYTE,这里是300K

	if ($_SERVER['REQUEST_METHOD'] == 'POST')  
	{  
		if (!is_uploaded_file($_FILES["upfile"]["tmp_name"])){	//是否存在文件  
			echo '{"status":-1,"content":"图片不存在！"}';   
			exit;  
		}  
		$file = $_FILES["upfile"];  
		if($max_file_size < $file["size"]){	//检查文件大小 
			echo '{"status":-2,"content":"文件太大！不得超过300K"}';   
			exit;  
		}  
		if(!in_array($file["type"], $uptypes)){   //检查文件类型  
			$msg = "文件类型不符!".$file["type"];
			echo '{"status":-3,"content":"'.$msg.'"}';   
			exit;  
		}  
		if(!file_exists($dest_folder)){  
			mkdir($dest_folder);  
		}  
	  
		$filename=$file["tmp_name"];  
		$image_size = getimagesize($filename);  
		$pinfo=pathinfo($file["name"]);  
		$ftype=$pinfo['extension'];  
		$destination = $dest_folder.$uploadfile.".".$ftype;   
		if(!move_uploaded_file ($filename, $destination)){  
			echo '{"status":-4,"content":"移动文件出错！"}';   
			exit;  
		}  
	  
		$pinfo=pathinfo($destination);
		$fname=$pinfo['basename'];  	
	}  
	echo '{"status":0,"content":"图片上传成功！"}';     
	
//	echo "图片上传成功！";
//	'{name:"jack"}';
//	echo '{"status":1,"name":"'.$picname.'","url":"'.$pic_path.'","size":"'.$size.'","content":"上传成功"}';
}

	$folder = $_GET['foldername'];
	$file = $_GET['filename'];
		
	if(getImgNum($folder)>=3){
		echo '{"status":-5,"content":"每个车辆最多上传3张图片！"}';
	}else {
		uploadimage_trans($folder,$file);
	}
?>  


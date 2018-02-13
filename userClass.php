<?php 

class User{
    //声明属性
    var $username;
    var $password;
    var $role_level;
	var $token;
	var $token_exptime;
	var $active_status;
    var $approvedDG;
	var $nick_name;
	var $first_name;
	var $surname;
	var $phoneNumber;
	var $email;
	var $country;
	var $city;
	var $address;
	var $postcode;
	var $url;
	var $brief;
	var $message;
	var $email_active;
	var $mobile_active;
	var $reg_time;
	
	//成员方法
    function call(){
     
    }
 
    function message(){
 
    }
 
    function playMusic(){
 
    }
 
    function photo(){
 
    }
}


	session_start();

	$headimg = './images/user/'.$_GET['id'].'/head.jpg';
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
			
			echo "<table align=center width=600>";
			echo "<tr><td width=100>个人头像</td>";	
		//	require 'phpmethod/commonMethod.php';
		//	showimage();	
		
		//	echo "<td><img src=\"./images/default_head.JPG\" width=\"90\" height=\"100\" border=\"0\"/>";
			echo "<td><img src=\"".$tmpimg."\" width=\"90\" height=\"100\" border=\"0\"/>";
	?>
			<form action="uploadheadpic.php?username=<?php echo $_GET['id']?>"
			enctype = "multipart/form-data" method="post" name="idimage" id="idimage" target="idimage_result">
			<input name="upfile" type="file">  
			<input type="submit" id="upload" name="upload" value="上传照片" /><br>
			允许上传的文件类型为: JPG,PNG	
			</form>
			<iframe id = "idimage_result" name = "idimage_result" style="" frameborder=0 
width=300px height=50px marginheight=0 marginwidth=0></iframe>

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
				name=\"email\" size=\"43.5\" value=\"".$row['email']."\"></td></tr>";
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
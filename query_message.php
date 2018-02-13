<?php include 'dbconnect.php';
header("Content-type:text/html;charset=UTF-8");
$conn = @mysql_connect($dbserver,$dbuser,$dbpwd);
if (!$conn){
    die("连接数据库失败：" . mysql_error());
}

mysql_select_db($dbname, $conn);
mysql_set_charset('utf8', $conn); 
//mysql_query("set character set 'gbk'");   //避免中文乱码字符转换
//mysql_query("set character set 'utf8'");   // PHP 文件为 utf-8 格式时使用
$sql = "SELECT * FROM message_board";
$result = mysql_query($sql);                //得到查询结果数据集

//循环从数据集取出数据
while( $row = mysql_fetch_array($result) ){
    echo "公司名:".$row['company_name']."<br />";
    echo "地址:".$row['address']."<br /><br />";
}
?>

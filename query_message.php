<?php include 'dbconnect.php';
header("Content-type:text/html;charset=UTF-8");
$conn = @mysql_connect($dbserver,$dbuser,$dbpwd);
if (!$conn){
    die("�������ݿ�ʧ�ܣ�" . mysql_error());
}

mysql_select_db($dbname, $conn);
mysql_set_charset('utf8', $conn); 
//mysql_query("set character set 'gbk'");   //�������������ַ�ת��
//mysql_query("set character set 'utf8'");   // PHP �ļ�Ϊ utf-8 ��ʽʱʹ��
$sql = "SELECT * FROM message_board";
$result = mysql_query($sql);                //�õ���ѯ������ݼ�

//ѭ�������ݼ�ȡ������
while( $row = mysql_fetch_array($result) ){
    echo "��˾��:".$row['company_name']."<br />";
    echo "��ַ:".$row['address']."<br /><br />";
}
?>

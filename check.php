<?php
header('Content-type:text/html;charset=utf-8');
session_start();
echo $_POST['verify'];
echo $_SESSION['login_check_number'];
if(strtoupper($_POST['verify'])!=$_SESSION['login_check_number']){
echo '验证失败';
}else{
echo '验证成功';
}
?>
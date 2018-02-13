<?php
header("Content-type:text/html;charset=UTF-8");
session_start();
unset($_SESSION['username']);
unset($_SESSION['nick_name']);
echo "<script>window.location.href = \"index.php\"</script>";
?>

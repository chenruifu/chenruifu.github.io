<?php 
header("Content-Type: text/html; charset=utf-8");
session_start();
if(strtolower($_POST['codeInput'])==$_SESSION['code']){
	echo '登陆成功';
}else{
	echo "<script>alert('验证码错误');history.go(-1);</script>";
	exit();
}

 ?>
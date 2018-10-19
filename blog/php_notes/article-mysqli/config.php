<?php 
header("Content-type:text/html;charset=utf-8");
$mysqli=new mysqli("127.0.0.1","root","root",'article');
if($mysqli->connect_error){
	die("连接数据库失败<br/>".$mysqli->connect_error());
}
$mysqli->set_charset('utf8');
 ?>
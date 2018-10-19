<?php 
header("Content-type:text/html;charset=utf-8");
if(!$sql_db=mysql_connect("127.0.0.1","root","root")){
	echo "连接数据库失败<br/>".mysql_error();
}
if(!mysql_select_db('article')){
	echo '选择数据库失败'.mysql_error();
}
mysql_query('set names utf8');
 ?>
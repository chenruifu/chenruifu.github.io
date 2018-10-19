<?php 
	require_once('config.php');
	if(!isset($_GET['id'])&&empty($_GET['id'])){
		echo "<script>alert('出错了');window.location.href='act.list.php';</script>";
	}else{
		$id=$_GET['id'];
		$sql="delete from article where id=$id";
		$req=mysql_query($sql);
		if($req){
			echo "<script>alert('删除成功');window.location.href='act.list.php';</script>";
		}else{
			echo "<script>alert('删除失败');window.location.href='act.list.php';</script>";
		}
		
	}
 ?>
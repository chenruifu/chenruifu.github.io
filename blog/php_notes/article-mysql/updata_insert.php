<?php 
	require_once('config.php');
	$title=$_POST['title'];
	$author=$_POST['author'];
	$intro=$_POST['intro'];
	$content=$_POST['content'];
	if(isset($_GET['id'])&&!empty($_GET['id'])){
		$id=$_GET['id'];
		$sql="update article set title='$title',author='$author',intro='$intro',content='$content' where id=$id";
		$req=mysql_query($sql);
		if($req){
			echo "<script>alert('修改成功');window.location.href='act.list.php';</script>";
		}else{
			echo "<script>alert('出错了');window.location.href='act.edit.php?id=$id';</script>";
		}	
	}else{
		$sql="insert into article(title,author,intro,content) value('$title','$author','$intro','$content')";
		$req=mysql_query($sql);
		if($req){
			echo "<script>alert('提交成功');window.location.href='act.list.php';</script>";
		}else{
			echo "<script>alert('出错了');window.location.href='act.edit.php';</script>";
		}	
	}
 ?>
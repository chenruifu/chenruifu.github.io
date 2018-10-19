<?php 
	require_once('config.php');
	$id=(isset($_GET['id'])&&!empty($_GET['id']))?$_GET['id']:'';
	$type=(isset($_GET['type'])&&!empty($_GET['type']))?$_GET['type']:'';
	switch ($type) {
		case 'updata':
			$title=$_POST['title'];
			$author=$_POST['author'];
			$intro=$_POST['intro'];
			$content=$_POST['content'];
			$sql="update article set title='$title',author='$author',intro='$intro',content='$content' where id=$id";
			$req=$mysqli->query($sql);
			if($req){
				echo "<script>alert('修改成功');window.location.href='list.php';</script>";
			}else{
				echo "<script>alert('出错了');window.location.href='edit.php?type=updata&id=$id';</script>";
			}	
			break;
		case 'insert':
			$title=$_POST['title'];
			$author=$_POST['author'];
			$intro=$_POST['intro'];
			$content=$_POST['content'];
			$sql="insert into article(title,author,intro,content) value('$title','$author','$intro','$content')";
			$req=$mysqli->query($sql);
			if($req){
				echo "<script>alert('提交成功');window.location.href='list.php';</script>";
			}else{
				echo "<script>alert('出错了');window.location.href='edit.php';</script>";
			}
			break;
		case 'delete':
			$id=$_GET['id'];
			$sql="delete from article where id=$id";
			$req=$mysqli->query($sql);
			if($req){
				echo "<script>alert('删除成功');window.location.href='list.php';</script>";
			}else{
				echo "<script>alert('删除失败');window.location.href='list.php';</script>";
			}
			break;
		default:
			echo "<script>alert('程序出错了');window.location.href='list.php';</script>";
			break;
	}
 ?>
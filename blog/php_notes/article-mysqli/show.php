<?php 
	require_once('config.php');
	$id=(isset($_GET['id'])&&!empty($_GET['id']))?$_GET['id']:'';
	if(!$id){
		echo "<script>alert('出错了');window.location.href='list.php';</script>";
	}else{
		$sql="select * from article where id=$id";
		$req=$mysqli->query($sql);
		$data=$req->fetch_array(MYSQL_ASSOC);
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>文章详情</title>
</head>
<body>
	<a style="width:60%;margin:0 auto;display:block" href="list.php">返回列表</a>
	<div style="text-align:center;width:80%;margin:0 auto">
		<h2><?php echo $data['title'] ?></h2>
		<p>作者：<?php echo $data['author'] ?></p>
		<br/>
		<div><?php echo $data['content'] ?></div>
	</div>
</body>
</html>
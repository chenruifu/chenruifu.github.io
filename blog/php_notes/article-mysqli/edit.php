<?php 
	require_once('config.php');
	$id=(isset($_GET['id'])&&!empty($_GET['id']))?$_GET['id']:'';
	$type=(isset($_GET['type'])&&!empty($_GET['type']))?$_GET['type']:'';
	if($type=='updata'){
		$sql="select * from article where id=$id";
		$req=$mysqli->query($sql);
		$data=$req->fetch_array(MYSQL_ASSOC);
	}else{
		$data='';
	}
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>文章修改新增</title>
</head>
<body>
	<a style="display:block" href="list.php">返回列表</a>
	<style>input,textarea{width:420px;}</style>
	<div style="text-align:center;width:80%;margin:0 auto">
		<form action="mysqli.php?type=<?php echo $type ?>&id=<?php echo empty($data)?'':$data['id'] ?>" method="post">
			<table>
				<tr>
					<td><label for="title">文章标题</label></td>
					<td><input type="text" id="title" name="title" value="<?php echo empty($data)?'':$data['title'] ?>"></td>
				</tr>
				<tr>
					<td><label for="author">文章作者</label></td>
					<td><input type="text" id="author" name="author" value="<?php echo empty($data)?'':$data['author'] ?>"></td>
				</tr>
				<tr>
					<td><label for="intro">文章简介</label></td>
					<td><input type="text" id="intro" name="intro" value="<?php echo empty($data)?'':$data['intro'] ?>"></td>
				</tr>
				<tr>
					<td><label for="content">文章内容</label></td>
					<td><textarea name="content" id="content" rows="20"><?php echo empty($data)?'':$data['content'] ?></textarea></td>
				</tr>
				<tr><td colspan="2"><input type="submit" value="确认提交"></td></tr>
			</table>
			
		</form>
	</div>
</body>
</html>
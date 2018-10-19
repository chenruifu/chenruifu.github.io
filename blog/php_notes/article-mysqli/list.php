<?php 
	require_once('config.php');
	$sql="select * from article";
	$req=$mysqli->query($sql);
	if($req&&$mysqli->affected_rows){
		while ($row=$req->fetch_array(MYSQL_ASSOC)) {
			$data[]=$row;
		}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>文章列表</title>
</head>
<body>
	<h2 style="text-align:center">文章列表</h2>
	<table style="width:60%;margin:0 auto;text-align:center">
		<tr><th>ID</th><th>标题</th><th>简介</th><th>作者</th><th>操作</th></tr>
		<?php foreach ($data as $val) { ?>
			<tr>
				<td><?php echo $val['id'] ?></td>
				<td><a href="show.php?id=<?php echo $val['id'] ?>"><?php echo $val['title'] ?></a></td>
				<td><?php echo $val['intro'] ?></td>
				<td><?php echo $val['author'] ?></td>
				<td>
					<a href="mysqli.php?type=delete&id=<?php echo $val['id'] ?>">删除</a>
					<a href="edit.php?type=updata&id=<?php echo $val['id'] ?>">修改</a>
				</td>
			</tr>
		<?php } ?>
	</table>
	<h2 style="text-align:center"><a href="edit.php?type=insert">新增文章</a></h2>
</body>
</html>
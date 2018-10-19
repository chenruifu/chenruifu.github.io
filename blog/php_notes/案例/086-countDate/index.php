<?php 
header("content-type: text/html;charset=utf-8");

$a='';
$old='';
$now='';
if($_GET['old'] && $_GET['now']){
	$old=strtotime($_GET['old']);
	$now=strtotime($_GET['now']);
	$a=($now-$old)/60/60/24;
	$old=date('Y-m-d',$old);
	$now=date('Y-m-d',$now);
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>日期计算</title>
	<style>
	*{margin: 0;padding:0;}
	.box{
		width: 600px;
		height: 300px;
		border:4px solid red;
		margin: 30px auto;
		text-align: center;
	}
	.box p{
		text-align: center;
		margin: 14px 0;
	}
	</style>
</head>
<body>
	<form action="">
		<div class="box">
			<p>日期计算(格式：2010-10-10)</p>
			<p>起始时间：<input type="text" name="old"></p>
			<p>结束时间：<input type="text" name="now"></p>
			<p><input type="submit" value="提交"></p>
			<p><?php echo $old ?></p>
			<p><?php echo $now ?></p>
			<p>结果: <?php echo $a ?>天</p>
		</div>
	</form>
</body>
</html>
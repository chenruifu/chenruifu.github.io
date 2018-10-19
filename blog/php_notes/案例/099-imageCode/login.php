<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登陆首页</title>
</head>
<body>
	<div style="text-align:center;width:800px;margin:0 auto;border:1px solid red">
		<form action="input.php" method="post">
			请输入验证码:<br/>
			<input type="text" name="codeInput"><br/>
			<img src="check.php" alt="" onclick="this.src='check.php?'+Math.random()"><br/>
			<input type="submit" value="提交">
		</form>
	</div>
</body>
</html>

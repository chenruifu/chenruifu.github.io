


 <?php 
header("Content-Type: text/html; charset=utf-8");

echo '<pre>';
//过滤掉值为空的数组，返回新数组
$newArr=array_filter($_FILES['file']['name']);

$db=new mysqli('localhost','root','root','ruei');

foreach ($newArr as $key => $value) {
	$dir='upload/'.date('ymd');
	if(!file_exists($dir)){//判断文件夹是否存在
		mkdir($dir);
	}
	//文件路径 随机数 命名 
	$uploadFileName=$dir.'/'.rand().rand().strrchr($value, '.');
	if(move_uploaded_file($_FILES['file']['tmp_name'][$key],$uploadFileName)){
		$sql="insert into uploadFile(fname,fpath,fsize,ftime) value('".$value."','".$uploadFileName."','".filesize($uploadFileName)."','".filectime($uploadFileName)."')";
		$db->query($sql);	
	}else{
		die("错误！上传失败");
	}
}
echo "上传成功";
echo "<br/><a href='download.php'>超链接下载页</a>";
echo "<br/><a href='downHeader.php'>headerb表头下载页</a>";

 ?>

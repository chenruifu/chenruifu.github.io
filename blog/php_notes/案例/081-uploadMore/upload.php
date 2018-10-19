<?php 
header("Content-Type: text/html; charset=utf-8");

echo '<pre>';
//把空上传文件，剔除
$newArr=array_filter($_FILES['file']['name']);

foreach ($newArr as $key => $value) {
	$dir='upload/'.date('ymd');
	//判断文件夹是否存在
	if(!file_exists($dir)){
		mkdir($dir);
	}
	$uploadFileName=$dir.'\\'.time().$value;
	//转码
	$uploadFileName=iconv("UTF-8","GB2312", $uploadFileName);
	if(move_uploaded_file($_FILES['file']['tmp_name'][$key],$uploadFileName)){
		echo "上传成功";
	}else{
		echo "错误！上传失败";
	}
}



 ?>
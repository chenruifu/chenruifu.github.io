<?php 
header("Content-Type: text/html; charset=utf-8");
//单文件上传
echo '<pre>';
// print_r($_FILES['logo']);
// echo realpath('.');
// $dir=realpath('.').'\upload\\'.date('ymd');

//对于 IE，识别 jpg 文件的类型必须是 pjpeg，对于 FireFox，必须是jpeg
$needTypeArr=array('image/png','image/jpeg','image/pjpeg');
if(is_uploaded_file($_FILES['logo']['tmp_name'])){
	if(in_array($_FILES['logo']['type'],$needTypeArr)){
		if(($_FILES['logo']['size']/1024/1024)<=1){
			$dir='upload/'.date('ymd');
			if(!file_exists($dir)){
				mkdir($dir);
			}
			$uploadFileName=$dir.'\\'.time().$_FILES['logo']['name'];
			$uploadFileName=iconv("UTF-8","GB2312", $uploadFileName);
			if(move_uploaded_file($_FILES['logo']['tmp_name'],$uploadFileName)){
				echo "上传成功";
			}else{
				echo "错误！上传失败";
			}
		}else{
			echo '你上传的图片太大,图片大小须小于1Mb';
		}
	}else{
		echo '上传失败,图片格式必须是png,jpeg,pjpg';
	}
}else{
	echo '非法操作,请重新操作';
}
	
 ?>
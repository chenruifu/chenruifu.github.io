<?php 
header("Content-Type: text/html; charset=utf-8");
echo '<pre>';

//删除目录，如果有传文件后缀，则只删除目录内的文件
function delDir($dir,$type=''){
	if(!is_dir($dir)) return '没有此目录';
	if($type!==''){
		is_array($type) ? $types=$type : $types[]=$type;
	}else{
		$types=false;
	}
	$arr=scandir($dir);
	foreach ($arr as $val) {
		if($val!='.' && $val!='..'){
			$vals=$dir.'\\'.$val;
			if(is_dir($vals)){
				delDir($vals,$type);
			}else{
				echo $dir.'\\'.$val.'<br/>';
				$v=substr(strrchr($val,'.'),1);
				echo $v.'<br/>';
				if($types==false){
					unlink($dir.'\\'.$val);
				}elseif(in_array($v,$types)){
					unlink($dir.'\\'.$val);
				}
				
			}
		}
	}
	if($type==false){
		rmdir($dir);
		return '删除目录成功';
	}else{
		return '删除文件成功';
	}
}
echo delDir('061');


 ?>
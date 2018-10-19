<?php
//单入口文件
header("Content-Type: text/html; charset=utf-8");


$a=isset($_GET['a'])?$_GET['a']:'index';

$obj=new $a();
$obj->sdb();
function __autoload($class){
	if($class=='index'){
		echo '你访问的类不存在';
	}elseif($class=='addAction'){
		include __DIR__."\Action\\{$class}.php";
	}elseif($class=='searchAction'){
		include __DIR__."\Action\\{$class}.php";
	}elseif($class=='db'){
		include __DIR__."\Db\\{$class}.php";
	}
}
 ?>
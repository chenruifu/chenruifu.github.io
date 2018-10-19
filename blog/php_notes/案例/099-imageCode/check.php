<?php
session_start();

function __autoload($className){
	require $className.'.class.php';
}

$img=new imageCode();
$img->showCode();

$_SESSION['code'] = $img->getCode();
?>
 
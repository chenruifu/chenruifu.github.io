<?php 

header("content-type: text/html;charset=utf-8");
$needTypeArr=array('image/png','image/jpeg','image/pjpeg','image/gif');
if(is_uploaded_file($_FILES['img']['tmp_name'])){
	if(in_array($_FILES['img']['type'],$needTypeArr)){
		if(($_FILES['img']['size']/1024/1024)<=1){
			$dir='upload/'.date('ymd');
			if(!file_exists($dir)){
				mkdir($dir);
			}
			$upload=$dir.'/'.time();
			$uploadFileName=$upload.strrchr($_FILES['img']['name'], '.');
			$uploadFileName=iconv("UTF-8","GB2312", $uploadFileName);
			if(move_uploaded_file($_FILES['img']['tmp_name'],$uploadFileName)){
				echo "<script>alert('上传成功');</script>";
				$imgInfo=getimagesize($uploadFileName);
				if($imgInfo[0]<100 || $imgInfo[1]<100 || $imgInfo[0]>1000 || $imgInfo[1]>700){
					die("图片太小或太小，无法操作啊<a href='imageInput.html'>返回</a>");
				}
			}else{
				echo "<script>alert('错误！上传失败');history.go(-1);</script>";
			}
		}else{
			echo "<script>alert('你上传的图片太大,图片大小须小于1M');history.go(-1);</script>";
		}
	}else{
		echo "<script>alert('上传失败,图片格式必须是png,jpeg,jpg,gif');history.go(-1);</script>";

	}
}else{
	echo '非法操作,请重新操作';
}

switch ($imgInfo[2]) {
	case 1:
		$img=imagecreatefromgif($uploadFileName);
		break;
	case 2:
		$img=imagecreatefromjpeg($uploadFileName);
		break;
	case 3:
		$img=imagecreatefrompng($uploadFileName);
		break;
	default:
		break;
}
$cutNum=4;//拆分的行列
$cutW=$imgInfo[0]/$cutNum;
$cutH=$imgInfo[1]/$cutNum;
for($i=0;$i<$cutNum;$i++){
	for($b=0;$b<$cutNum;$b++){
		$bg=imagecreatetruecolor($cutW,$cutH);
		imagecopy($bg,$img,0,0, $i*$cutW, $b*$cutH, $cutW, $cutW);
		imagejpeg($bg,$upload.'_'.$i.$b.'.jpg');
		imagedestroy($bg);
	}
}
imagedestroy($img);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>拼图游戏</title>
	<style>
		body{background: #ccc;}
		.box{
			width:<?php echo $imgInfo[0] ?>;
			height:<?php echo $imgInfo[1] ?>;
			border:5px solid red;
			margin: 0 auto;
			position: relative;
			background: #333333;
		}
		.box img{
			display: block;
			position: absolute;
			width:<?php echo $cutW ?>;
			height:<?php echo $cutH ?>;
			cursor: move;
			z-index: 1;
		}
	</style>
</head>
<body>
	<div class="box">
		<?php
		for($i=0;$i<$cutNum;$i++){
			for($b=0;$b<$cutNum;$b++){
				echo "<img src='".$upload.'_'.$i.$b.'.jpg'."' class='dragme'>";
			}
		}
		?>
	</div>
</body>
</html>
<script src="jquery.js"></script>
<script>
	$(function(){
		var boxW=$('.box').width();
		var boxH=$('.box').height();
		var cutW=$('.box img').width();
		var cutH=$('.box img').height();
		var imgNum=$('.box img').length;
		for(var i=0;i<imgNum;i++){
			$('.box img').eq(i).css({left:getRandW(),top:getRandH()});
		}
		function getRandW(){
			return Math.floor(Math.random()*(boxW-cutW)+1)
		}
		function getRandH(){
			return Math.floor(Math.random()*(boxH-cutH)+1)
		}
	})
</script>
<script type="text/javascript">
var ie=document.all;
var nn6=document.getElementById && !document.all;
var isdrag=false;
var x,y;
var dobj;
var zIndex=1;
var positionX,positionY;
var yesNum=0;

function movemouse(e){

	if (isdrag){
		var nowX=parseInt(dobj.style.left);
		var nowY=parseInt(dobj.style.top);
		if(Math.abs(nowX-positionX)<=5 && Math.abs(nowY-positionY)<=5){
			isdrag=false;
			dobj.style.left=positionX+'px';
			dobj.style.top=positionY+'px';
			dobj.style.zIndex=0;
			dobj.style.cursor='default';
			yesNum=yesNum+1;
			console.log(yesNum);
			if(yesNum==<?php echo $cutNum*$cutNum ?>){
				alert('你真棒');
			}
			return false;
		}else{
			dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
			dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
		}
		
		
	 	
	}
}

function selectmouse(e){
	var fobj = nn6 ? e.target : event.srcElement;
  	var topelement = nn6 ? "HTML" : "BODY";
  	while (fobj.tagName != topelement  &&  fobj.className != "dragme"){
    	fobj = nn6 ? fobj.parentNode : fobj.parentElement;
  	}
  	if (fobj.className=="dragme"){
	    isdrag = true;
	    dobj = fobj;
	    var src = dobj.src;
		var srcNum=src.search('_');
		positionX=src.substr(srcNum+1,1)*<?php echo $cutW?>;
		positionY=src.substr(srcNum+2,1)*<?php echo $cutH?>;
		console.log(positionX+','+positionY);
	    dobj.style.zIndex=++zIndex;
	    tx = parseInt(dobj.style.left+0);
	    ty = parseInt(dobj.style.top+0);
	    x = nn6 ? e.clientX : event.clientX;
	    y = nn6 ? e.clientY : event.clientY;
	    document.onmousemove=movemouse;
	    return false;
  	}
}
document.onmousedown=selectmouse;
document.onmouseup=new Function("isdrag=false;");
</script>

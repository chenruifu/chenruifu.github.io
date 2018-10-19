<?php 
//header下载，不管是什么文件  都会弹出窗口下载
$url =parse_url($_SERVER['REQUEST_URI']);
if(!isset($_GET['fpath'])){
	header("Content-Type: text/html; charset=utf-8");
	$db=new mysqli('localhost','root','root','ruei');
	$sql="select * from uploadFile";
	$result=$db->query($sql);
	echo "<table width='600px'>";
	echo '<tr><td>ID</td><td>文件名</td><td>文件大小</td><td>上传时间</td><td>下载</td></tr>';
	while($row=$result->fetch_assoc()){
		echo "<tr><td>".$row['id']."</td>";
		echo "<td>".$row['fname']."</td>";
		echo "<td>".round(($row['fsize']/1024),2)."Kb</td>";
		echo "<td>".date('Y-m-j H:i',$row['ftime'])."</td>";
		echo "<td><a href='".$url['path']."?fpath=".$row['fpath']."&fname=".$row['fname']."'>下载</a></td></tr>";
	}
	echo '</table>';
}else{
	$a=fopen($_GET['fpath'],'r');//打开文件
	//不设置文件的是什么类型  image/png 。。。
	header("Content-type: application/octet-stream");
	//文件的大小单位
	header("Accept-Ranges: bytes");
	//文件的大小
	header("Accept-Length:".filesize($_GET['file']));
	//设置文件都弹窗下载，filename = 设置文件的名字
	Header("Content-Disposition: attachment;filename=".$_GET['fname']);
	echo fread($a, filesize($_GET['file']));
	fclose($a);
}

 ?>
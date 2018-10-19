<?php 
header("Content-Type: text/html; charset=utf-8");
//a链接下载，浏览器认得文件属性，会在浏览器直接打开
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
	echo "<td><a href='".$row['fpath']."'>下载</a></td></tr>";
}
echo '</table>';

?>

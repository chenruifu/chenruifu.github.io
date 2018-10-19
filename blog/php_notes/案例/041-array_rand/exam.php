<?php 
header("Content-Type: text/html; charset=utf-8");

$questions=array(
	array('name'=>'北京奥运会在哪一年举办?','type'=>'radio','select'=>'1998,2004,2008,2012'),
	array('name'=>'北京奥运会几号闭幕?','type'=>'input'),
	array('name'=>'北京奥运会吉祥物?','type'=>'input'),
	array('name'=>'北京奥运会口号?','type'=>'input'),
	array('name'=>'北京奥运会主题曲+歌词?','type'=>'textarea')
);
echo '<pre>';
function randExam($arr,$num=1){
	if($num>1 && $num<count($arr)){		//随机的题目数在1-总题数之间
		$randArr=array_rand($arr,$num);
		foreach($randArr as $v){
			switch ($arr[$v]['type']) {
			 	case 'input':
			 		echo $arr[$v]['name'].'<br/>';
			 		echo "<input type='text'><br/>";
			 		break;
			 	case 'textarea':
			 		echo $arr[$v]['name'].'<br/>';
			 		echo "<textarea name='' cols='35' rows='10'></textarea>";
			 		break;
			 	case 'radio':
			 		echo $arr[$v]['name'].'<br/>';
			 		$radioArr=explode(',',$arr[$v]['select']);
			 		foreach($radioArr as $v){
			 			echo "<input type='radio'>{$v}&nbsp;&nbsp;";
			 		}
			 		echo '<br/>';
			 		break;
			}
		}
	}elseif($num<=1){		//未输入题数，或输入小于1的数
		$randArr=array_rand($arr);
		switch ($arr[$randArr]['type']) {
		 	case 'input':
		 		echo $arr[$randArr]['name'].'<br/>';
		 		echo "<input type='text'><br/>";
		 		break;
		 	case 'textarea':
		 		echo $arr[$randArr]['name'].'<br/>';
		 		echo "<textarea name='' cols='35' rows='10'></textarea>";
		 		break;
		 	case 'radio':
		 		echo $arr[$randArr]['name'].'<br/>';
		 		$radioArr=explode(',',$arr[$randArr]['select']);
		 		foreach($radioArr as $v){
		 			echo "<input type='radio'>{$v}&nbsp;&nbsp;";
		 		}
		 		echo '<br/>';
		 		break;
		}
	}else{		//大于总题数，按全部输出
		for($i=0;$i<count($arr);$i++){
			switch ($arr[$i]['type']) {
			 	case 'input':
			 		echo $arr[$i]['name'].'<br/>';
			 		echo "<input type='text'><br/>";
			 		break;
			 	case 'textarea':
			 		echo $arr[$i]['name'].'<br/>';
			 		echo "<textarea name='' cols='35' rows='10'></textarea>";
			 		break;
			 	case 'radio':
			 		echo $arr[$i]['name'].'<br/>';
			 		$radioArr=explode(',',$arr[$i]['select']);
			 		foreach($radioArr as $v){
			 			echo "<input type='radio'>{$v}&nbsp;&nbsp;";
			 		}
			 		echo '<br/>';
			 		break;
			}
		}
	}
}
randExam($questions,6);
?>
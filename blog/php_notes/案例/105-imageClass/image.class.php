<?php
/*
图像处理类

水印图片处理	image::water
水印文字处理	image::text
图像缩略图处理	image::thumb

处理成功都返回true
*/

/******水印图配置项*******/
//水印图路径
define('WATER_IMAGE', 'logo.png');
//水印透明度
define('WATER_ALPHA', 60);

/******水印图，水印文字公共配置项*******/
//水印位置
define('WATER_POS', 9);
//JPEG图片压缩比
define('WATER_COMPRESSION', 80);

/******文字水印配置项*******/
//水印文字
define('WATER_TEXT', 'ChaRmFree');
//水印文字旋转角色
define('WATER_ANGLE', 0);
//水印文字大小
define('WATER_FONTSIZE', 80);
//水印文字颜色
define('WATER_FONTCOLOR', '#000000');
//水印文字字体文件(写入中文字时需使用支持中文的字体文件)
define('WATER_FONTFILE', './font.ttf');
//水印文字字符编码
define('WATER_CHARSET', 'UTF-8');


/******缩略图配置项*******/
//等比例缩放
//缩略图宽度
define('THUMB_WIDTH', 300);
//缩略图高度
define('THUMB_HEIGHT', 120);


class image{
	//图像检测
	static private function checkCondition ($file = NULL) {
		return is_null($file) ? extension_loaded('GD') && function_exists('imagecreatetruecolor') && function_exists('imagepng') : extension_loaded('GD') && file_exists($file);
	}

	//获取图片类型
	static private function getImageType($typeNum){
		//$typeNum为getimagesize返回的：索引 2 图像类型的标记
		switch($typeNum) {
			case 1 : 
				return 'gif';
			case 2 :
				return 'jpeg';
			case 3 :
				return 'png';
		}
	}

	//水印放置位置
	static private function getPosition($IW,$IH,$WW,$WH,$pos){
		// 原图宽度\高度	$IW\$IH
		// 水印宽度\高度	$WW\$WH
		// 位置			$pos
		$x=20;
		$y=20;
		switch ($pos) {
			case 1:
				break;
			case 2:
				$x=($IW -$WW)/2;
				break;
			case 3:
				$x=$IW-$WW-20;
				break;
			case 4:
				$y=($IH -$WH)/2;
				break;
			case 5:
				$x=($IW -$WW)/2;
				$y=($IH -$WH)/2;
				break;
			case 6:
				$x=$IW-$WW-20;
				$y=($IH -$WH)/2;
				break;
			case 7:
				$y=$IH -$WH-20;
				break;
			case 8:
				$x=($IW-$WW)/2;
				$y=$IH -$WH-20;
				break;
			case 9:
				$x=$IW-$WW-20;
				$y=$IH -$WH-20;
				break;	
			default:
				$x = mt_rand(0, $IW - $WW);
				$y = mt_rand(0, $IH - $WH);
				break;
		}
		return array('x' => $x, 'y' => $y);
	}

	//16进制颜色,转化为rgb值
	static private function getColorRGB($str){
		// $str==='#000000'
		return array(
			'red'=>hexdec($str[1].$str[2]),
			'green'=>hexdec($str[3].$str[4]),
			'blue'=>hexdec($str[5].$str[6])
		);
	}

	//图像水印
	static public function water($img,$water='',$save=null){
		//先判断图像gd库是否开启
		if(!self::checkCondition($img)) return false;
		//配置参数
		$water = empty($water) ? WATER_IMAGE : $water;
		$pos = WATER_POS;
		$alpha = WATER_ALPHA;
		$compression = WATER_COMPRESSION;
		//如果文件不存在
		if (!file_exists($water)) return false;

		//获取图像信息
		$imgInfo=getimagesize($img);
		$imgW=$imgInfo[0];
		$imgH=$imgInfo[1];
		$imgType=self::getImageType($imgInfo[2]);
		//获取水印信息
		$waterInfo=getimagesize($water);
		$waterW=$waterInfo[0];
		$waterH=$waterInfo[1];
		$waterType=self::getImageType($waterInfo[2]);
		//如果水印宽高大于原图
		if($imgW<$waterW || $imgH<$waterH) return false;
		//计算水印的位置,返回数组x,y
		$pos=self::getPosition($imgW,$imgH,$waterW,$waterH,$pos);
		$x=$pos['x'];
		$y=$pos['y'];

		//打开原图资源
		$fn='imagecreatefrom'.$imgType;
		$img_res=$fn($img);

		//打开水印资源
		$fn='imagecreatefrom'.$waterType;
		$water_res=$fn($water);

		//盖上水印图
		if ($waterType == 'png') {
			//因为png本身就带有透明，所有不能用imagecopymerge
			imagecopy($img_res, $water_res, $x, $y, 0, 0, $waterW, $waterH);
		} else {
			imagecopymerge($img_res, $water_res, $x, $y, 0, 0, $waterW, $waterH, $alpha);
		}

		//保存图片
		$fn = 'image' . $imgType;
		if ($imgType == 'jpeg') {
			$fn($img_res, $save, $compression);
		} else {
			$fn($img_res, $save);
		}

		//释放资源
		imagedestroy($img_res);
		imagedestroy($water_res);
		return true;

	}

	//文字水印
	static public function text($img,$text='',$save=null){
		//判断GD库是否开启
		if(!self::checkCondition($img)) return false;
		//配置参数
		$text = empty($text) ? WATER_TEXT : $text;
		$angle = WATER_ANGLE;
		$fontSize = WATER_FONTSIZE;
		$fontColor = WATER_FONTCOLOR;
		$fontFile = WATER_FONTFILE;
		$charset = WATER_CHARSET;
		$pos = WATER_POS;
		$compression = WATER_COMPRESSION;

		//获取图像信息
		$imgInfo=getimagesize($img);
		$imgW=$imgInfo[0];
		$imgH=$imgInfo[1];
		$imgType=self::getImageType($imgInfo[2]);
		//获取水印文字信息
		$waterInfo=imagettfbbox($fontSize, $angle, $fontFile, $text);
		$waterW=$waterInfo[2] - $waterInfo[0];
		$waterH=$waterInfo[1] - $waterInfo[7];
		//计算水印的位置,返回数组x,y
		$pos=self::getPosition($imgW,$imgH,$waterW,$waterH,$pos);
		$x=$pos['x'];
		$y=$pos['y']+$waterH;

		//打开原图资源
		$fn='imagecreatefrom'.$imgType;
		$img_res=$fn($img);

		//盖上水印图
		$rgb=self::getColorRGB($fontColor);
		$color=imagecolorallocate($img_res, $rgb['red'], $rgb['green'], $rgb['blue']);
		$text=iconv($charset,'utf-8', $text);
		imagettftext($img_res, $fontSize,$angle, $x, $y, $color, $fontFile, $text);
		
		//保存图片
		$fn = 'image' . $imgType;
		if ($imgType == 'jpeg') {
			$fn($img_res, $save, $compression);
		} else {
			$fn($img_res, $save);
		}

		//释放资源
		imagedestroy($img_res);
		return true;
	}

	static public function thumb($img,$width='',$height='',$save=null){
		//判断GD库是否开启
		if(!self::checkCondition($img)) return false;
		//配置项
		$width=empty($width)?THUMB_WIDTH:$width;
		$height=empty($height)?THUMB_HEIGHT:$height;

		//获取图像信息
		$imgInfo=getimagesize($img);
		$imgW=$imgInfo[0];
		$imgH=$imgInfo[1];
		$imgType=self::getImageType($imgInfo[2]);

		//缩放比
		$ratio = max($width / $imgW, $height / $imgH);
		//缩略图大于原图不作处理
		if ($ratio >= 1) return false;

		//等比例缩放后宽、高
		$width = floor($imgW * $ratio);
		$height = floor($imgH * $ratio);

		//创建缩略图画布
		if ($imgType == 'gif') {
			$thumb = imagecreate($width, $height);
			$color = imagecolorallocate($thumb, 0, 255, 0);
		} else {
			$thumb = imagecreatetruecolor($width, $height);
			//PNG图片透明处理
			if ($imgType == 'png') {
				//关闭混色模式
				imagealphablending($thumb, false);
				//保存透明通道
				imagesavealpha($thumb, true);
			}
		}

		//打开原图资源
		$fn = 'imagecreatefrom' . $imgType;
		$image = $fn($img);

		//原图移至缩略图画布并调整大小
		if (function_exists('imagecopyresampled')) {
			imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $height, $imgW, $imgH);
		} else {
			imagecopyresized($thumb, $image, 0, 0, 0, 0, $width, $height, $imgW, $imgH);
		}

		//GIF图透明处理
		if ($imgType == 'gif') imagecolortransparent($thumb, $color);

		//保存图片
		$fn = 'image' . $imgType;
			$fn($thumb, $save);

		//释放资源
		imagedestroy($image);
		imagedestroy($thumb);
		return true;
	}

}

?>
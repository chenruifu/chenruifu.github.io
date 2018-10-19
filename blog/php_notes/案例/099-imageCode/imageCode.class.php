<?php 
class imageCode{
	public $img;
	public $strCode='qwertyuiopasdfghjklzxcvbnm0987654321QWERTYUIOPASDFGHJKLZXCVBNM';
	public $width=80;
	public $height=30;
	public $code;
	public $bgColor='#DCEAF9';
	public $fontColor='#CC0001';
	public $fontUrl='fz.ttf';
	public $fontSize=16;
	public $codeLen=4;

	public function __construct(){
		$this->codeImg();
	}
	public function codeImg(){
		//获取验证码
		$code='';
		for($i=0;$i<$this->codeLen;$i++){
			$code.=$this->strCode[mt_rand(0,strlen($this->strCode)-1)];
		}
		$this->code = $code;
		
		//建立画布
		$this->img=imagecreatetruecolor($this->width, $this->height);
		$bgColor=imagecolorallocate($this->img,
			hexdec(substr($this->bgColor,1,2)),
			hexdec(substr($this->bgColor,3,2)),
			hexdec(substr($this->bgColor,5,2))
			);
		imagefill($this->img, 0, 0, $bgColor);
		
		//写入验证码
		$fontColor=imagecolorallocate($this->img,
			hexdec(substr($this->fontColor,1,2)),
			hexdec(substr($this->fontColor,3,4)),
			hexdec(substr($this->fontColor,5,6))
		);
		$w=0;
		for($i=0;$i<strlen($this->code);$i++){
			$x = $this->width/$this->codeLen;
			$codeMap=imagettftext($this->img,
				$this->fontSize,
				mt_rand(-30,30),
				$x*$i+mt_rand(3,6),
				mt_rand($this->height/1.2,$this->height-5),
				$fontColor,
				$this->fontUrl,
				$this->code[$i]
				);
			$w=abs(abs($codeMap[3])-abs($codeMap[0]));
		}

		//写入干扰线，或点
		$rangNum=mt_rand(1,3);
		switch ($rangNum) {
			case '1':
				for($i=0;$i<200;$i++){
					imagesetpixel($this->img,
						mt_rand(0,$this->width), 
						mt_rand(0,$this->height),
						$fontColor);
				}
				break;
			case '2':
				for($i=0;$i<8;$i++){
					imageline($this->img,
						mt_rand(0,$this->width),
						mt_rand(0,$this->height), 
						mt_rand(0,$this->width),
						mt_rand(0,$this->height),
						$fontColor
					);
				}
				break;
			case '3':
				for($i=0;$i<100;$i++){
					imagesetpixel($this->img,
						mt_rand(0,$this->width), 
						mt_rand(0,$this->height),
						$fontColor);
				}
				for($i=0;$i<3;$i++){
					imageline($this->img,
						mt_rand(0,$this->width),
						mt_rand(0,$this->height), 
						mt_rand(0,$this->width),
						mt_rand(0,$this->height),
						$fontColor
					);
				}
				break;
			default:
				break;
		}
	}

	public function showCode(){ 
            header("Content-type:image/png");
            imagepng($this->img);
            imagedestroy($this->img);
	}
	public function getCode(){
            return strtolower($this->code);
	}
}








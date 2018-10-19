
<?php 
header("Content-Type: text/html; charset=utf-8");

class filePageClass{
	private $file;//传入的文件
	private $pageSize;//每页的大小
	private $pageCur;//当前页
	private $pageAll;//总页数
	private $url;//链接地址

	function __construct($file,$size=500){
		$this->file=iconv("gb2312", "utf-8",file_get_contents($file));
		$this->pageCur=isset($_GET['page'])?$_GET['page']:1;
		$this->pageSize=$size;
		$this->pageAll=ceil((mb_strlen($this->file,'utf-8')/$size));// ceil进一法取整 
		$this->url=$this->getUrl();
	}
	private function getUrl(){
		$url =parse_url($_SERVER['REQUEST_URI']);//获取url,截取成数组
		if(!isset($_GET['page'])) $url['query']=1;
		parse_str($url['query'],$queryArr);//把截取的数组,再赋值给新数组（关联数组）
		unset($queryArr['page']);//删除page
		$queryStr = http_build_query($queryArr);//生成删除page后的,url
		return  $url['path'].'?'.$queryStr.'&page=';	
	}
	private function fistPage(){
		if($this->pageCur>1){
			$return = "<a href='".$this->url."1'>首页</a>";
		}else{
			$return = "首页";
		}
		return $return;
	}
	private function prevPage(){
		if($this->pageCur>1){
			$return = "<a href='".$this->url.($this->pageCur-1)."'>上一页</a>";
		}else{
			$return = "上一页";
		}
		return $return;
	}
	private function nextPage(){
		if($this->pageCur<$this->pageAll){
			$return = "<a href='".$this->url.($this->pageCur+1)."'>下一页</a>";
		}else{
			$return = "下一页";
		}
		return $return;
	}
	private function lastPage(){
		if($this->pageCur<$this->pageAll){
			$return = "<a href='".$this->url.($this->pageAll)."'>末页</a>";
		}else{
			$return = "末页";
		}
		return $return;
	}
	private function numPage(){
		$return='';
		for($i=1;$i<=$this->pageAll;$i++){
			if($this->pageCur!=$i){
				$return.= "&nbsp;&nbsp;<a href='".$this->url.$i."'>".$i."</a>";
			}else{
				$return.= '&nbsp;&nbsp;'.$i;
			}
		}
		return $return;
	}
	public function pageStyle(){
		return '<br/><br/>总页数'.$this->pageAll.'&nbsp;&nbsp;'.
						$this->fistPage().'&nbsp;&nbsp;'.
						$this->prevPage().'&nbsp;&nbsp;'.
						$this->numPage().'&nbsp;&nbsp;'.
						$this->nextPage().'&nbsp;&nbsp;'.
						$this->lastPage();
	}
	public function fileCon(){
		//mb_substr 默认是关闭的，得配置ini 开启
		return mb_substr($this->file,($this->pageCur-1)*$this->pageSize,$this->pageSize,'utf-8');
	}
}

$filePage=new filePageClass('file.txt',1200);
echo "<div style='width:1000px;margin:0 auto;font-size:20px'>";
echo $filePage->fileCon();
echo $filePage->pageStyle();
echo '</div>';
 ?>
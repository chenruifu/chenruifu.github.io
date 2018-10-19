/**
 *	触屏左右拉动滚动Jquery插件1.0
 *  作者：黄伟聪
 *	时间：2011.07.09
 http://202.101.105.182/211/4
 *	
 */
(function($){
	$.fn.TouchScroll = function(options){
		var setting = {
			wrapEl:'.wrap', //外层容器。用来overflow遮罩的层
			touchEl:'.holder', //touch层容器。用来包裹列表内层元素的层
			childEl:'li', //内层元素。用来放图的层
			speed:0.9, //加速度。一般取0.9-1之间
			margin:0,
			triggerWidth: 50,
			listnum:false //显示当前滚动位置
		};
		if(options){
			$.extend(setting, options);
		};
		var width = 0;
		var wrapWidth = $(setting.wrapEl).width();
		var touch = $(this).find(setting.touchEl);
		var child = touch.find(setting.childEl);
			width = child.width()*child.size()+2*setting.margin*child.size();
			touch.width(width);
			touch.css('left',0);
		var max = 0;
		var min = -width+wrapWidth;
		var step = 10; //滚动精度
		var distance = 0;
		var curid=0,snid=0,NewPox=0;
		return $(this).each(function(){
			touch[0].onmousedown = touch[0].ontouchstart = start;
			//开始拖放
			function start(e){
				pox = touch.position().left;
				touch[0].ontouchmove = touch[0].onmousemove = moveDrag;
				touch[0].ontouchend = document.onmouseup = endDrag;
				StartPox = getClient(e);
				//拖放移动
				function moveDrag(e){
					MovePox = getClient(e);
					NewPox = MovePox-StartPox+pox;
					touch.css('left',NewPox);
				}
				
				function endDrag(e){
					EndPox = getClient(e);
					LastWidth = parseInt(touch.css('left'));
					LastWidth = Math.abs(LastWidth);
					var snid=0,getL=0;
					if(setting.fullscreen){
						var fnid = parseInt(LastWidth/wrapWidth);
						
						if(StartPox>EndPox){//往右
							getL = -(fnid+1)*wrapWidth;
							LastWidth = getL;
						}
						if(StartPox<EndPox){//往左
							getL = -(fnid)*wrapWidth;
							LastWidth = getL;
						}
						if(StartPox!=EndPox){
							if(Math.abs(StartPox-EndPox)<setting.triggerWidth){
								getL = -(fnid)*wrapWidth;
								LastWidth = getL;
							}
							touch.animate({left:getL},150,"","");
						}
					}
					
					if(min>NewPox){//拉到最右边
						touch.animate({left:min},150,"","");
						LastWidth = min;
					}
					if(max<NewPox){
						touch.animate({left:max},150,"","");
						LastWidth = 0;
					}
					if(setting.listnum){//显示当前位置
						var snid = Math.abs(parseInt(LastWidth/wrapWidth));
						selnum = $(".selnum a");
						selnum.attr("id",'');
						selnum.eq(snid).attr("id",'on');
					}
					touch[0].ontouchmove = touch[0].ontouchend = touch[0].onmousemove = document.onmouseup = null;
					//切换图片左下角标题
					if($("#arrowArticle")){
						$("#arrowArticle").html($("#arrowArticle").attr("name"+$("#on").attr("name"))); 
					}
				}
				function getClient(e){
					var coors = 0;
					if (e.changedTouches){ //iPhone
						coors = e.changedTouches[0].clientX;
					}else {
						coors = e.clientX;
					}
					return coors;
				}
			}
		});
	};

})(jQuery);
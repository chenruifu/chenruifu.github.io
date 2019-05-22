$(function(){
    // 服务轮播
    var scrollTop = 0;
    var scrollUl = $('#feedbackScroll').children('ul');

    function scrollTip() {
        var top = scrollUl.children('li').eq(0).outerHeight();
        if (Math.abs(scrollTop) == Math.abs(top)) {
            scrollUl.children('li').eq(0).appendTo(scrollUl);
            scrollUl.css("top", 0);
            scrollTop = 0;
        } else {
            scrollTop--;
            scrollUl.css("top", scrollTop);
        }
    }
    setInterval(scrollTip, 50);
});
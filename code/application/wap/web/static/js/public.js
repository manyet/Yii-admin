
//弹窗居中
function poplation() {
	var popH = - $('.pop_in').height()/2;
	var popW = - $('.pop_in').width()/2;
	$('.pop_in').css({"margin-left":popW,"margin-top":popH});
}

$(window).ready(function(e) {
	var winH = $(window).height() - $('.headerBox').height();//为了让中间部分高度等于浏览器的高度
	$('.limit-height').css({"min-height":winH});
});

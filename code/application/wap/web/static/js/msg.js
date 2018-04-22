!(function () {

//"use strict";

var msg = function () {
	this.version = '1.0.0';
	this.queue = {};
	this.index = 0;
};

/**
 * 吐司提示
 * @param {string} msg 提示文字
 * @param {int} time 提示消失时间，单位毫秒
 * @returns {undefined}
 */
msg.prototype.toast = function (msg, duration, callback) {
	var position = 2;
	if (typeof duration == "object"){
		position = duration.position;
		duration = duration.duration;
	}
	var elem = document.createElement('div'), defaultClass = 'pop_cuo fc-fff f-tc f-fs16 f-br5 hide';
	elem.className = defaultClass;
	elem.innerHTML = msg.toString().replace('\n', '<br/>');
	document.body.appendChild(elem);
	var $elem = $(elem), style = '';
	if (position == 3) { // 底部
		style = 'bottom:30px;top:auto;';
	} else if (position == 1) { // 顶部
		style = 'top:80px;';
	} else { // 顶部
		style = 'top:50%;margin-top:-' + $elem.outerHeight() / 2 + 'px';
	}
	elem.style = style;
//	elem.style.display = "block";
//	elem.style.marginLeft = '-' + elem.offsetWidth / 2 + 'px';
//	setTimeout(function(){
//		elem.className = defaultClass + ' modal-in';
//	},200);
	$elem.fadeIn();
	setTimeout(function(){
//		elem.className = defaultClass + ' modal-out';
//		setTimeout(function(){
//			typeof callback === 'function' && callback();
//			elem.parentNode.removeChild(elem);
//		},200);
		$elem.fadeOut(function() {
			typeof callback === 'function' && callback();
			$elem.remove();
		})
	}, duration || 2000);
};

/**
 * 显示迷你加载器
 */
msg.prototype.showIndicator = function (text) {
	this.hideIndicator();

//	var overlay = document.createElement('div'), elem;
//	overlay.className = 'preloader-indicator-overlay';
//	document.body.appendChild(overlay);
//	this.indicatorOverlay = overlay;

	elem = document.createElement('div');
	elem.className = 'loading_in2';
	elem.innerHTML = '<div class="loading_span2 bg_box">' + (text ? text.toString().replace('\n', '<br>') : '') + '</div>';
	document.body.appendChild(elem);
	this.indicator = elem;
};

/**
 * 隐藏迷你加载器
 */
msg.prototype.hideIndicator = function () {
	if (!this.indicator) return;
	this.indicator.parentNode.removeChild(this.indicator);
	this.indicator = null;
//	this.indicatorOverlay.parentNode.removeChild(this.indicatorOverlay);
//	this.indicatorOverlay = null;
};

/**
 * 显示加载器
 */
msg.prototype.showPreloader = function (text) {
	this.hidePreloader();

	var overlay = document.createElement('div'), elem;
	overlay.className = 'modal-overlay';
	document.body.appendChild(overlay);
	this.preloaderOverlay = overlay;

	elem = document.createElement('div');
	elem.className = 'modal modal-no-buttons';
	elem.style.display = 'block';
	elem.innerHTML = '<div class="modal-inner"><div class="modal-title">'+(typeof(text)!=='undefined'?text.toString().replace('\n', '<br/>'):'加载中')+'</div><div class="modal-text"><div class="preloader"></div></div></div><div class="modal-buttons "></div>';
	document.body.appendChild(elem);
	// 计算高度
	elem.style.marginTop = '-' + elem.offsetHeight / 2 + 'px';
	this.preloader = elem;

	setTimeout(function(){
		elem.className += ' modal-in';
		overlay.className += ' modal-overlay-visible';
	},100);
};

/**
 * 隐藏加载器
 */
msg.prototype.hidePreloader = function () {
	if (!this.preloader) return;
	var self = this;
	self.preloader.className = self.preloader.className.replace('modal-in', 'modal-out');
	self.preloaderOverlay.className = self.preloaderOverlay.className.replace(' modal-overlay-visible', '');
	setTimeout(function(){
		self.preloader.parentNode.removeChild(self.preloader);
		self.preloader = null;
		self.preloaderOverlay.parentNode.removeChild(self.preloaderOverlay);
		self.preloaderOverlay = null;
	},200);
};

/**
 * 警告弹层提示
 * @param {string} msg 提示文字
 * @param {function} callback 确认按钮回调
 * @returns {undefined}
 */
msg.prototype.alert = function (msg, callback) {
	var elem = document.createElement('div');
	elem.className = 'pop_bg hide next_pop';
	elem.innerHTML = '<div class="pop_in bg-fff"><p class="f-fs15 fc-333 f-lh18 f-pt20 f-pl10 f-pr10 f-tc">'
	+ msg.toString().replace('\n', '<br/>') + '</p><div class="f-mt15 f-mb20 f-tc"><button class="f-w40 btn2 btn_red f-fs16 f-pt10 f-pb10 fc-fff f-br5 confirm_btn">'+(window.language&&window.language['confirm'] || '确认')+'</button></div></div>';
	document.body.appendChild(elem);
	var $elem = $(elem), $pop = $elem.find('.pop_in');
	$elem.fadeIn();
	$pop.css({"marginLeft": - $pop.outerWidth() / 2 + 'px', "marginTop": - $pop.outerHeight() / 2 + 'px'});
	elem.addEventListener('click', function(){
		$elem.fadeOut(function(){
			typeof callback === 'function' && callback();
			$elem.remove();
		});
	}, false);
};

/**
 * 警告确认提示
 * @param {string} msg 提示文字
 * @param {function} callback 确认按钮回调
 * @param {function} callback 取消按钮回调
 * @returns {undefined}
 */
msg.prototype.confirm = function (msg, callback, cancel) {
	var elem = document.createElement('div');
	elem.className = 'pop_bg hide next_pop';
	elem.innerHTML = '<div class="pop_in bg-fff"><p class="f-fs15 fc-333 f-lh18 f-pt20 f-pl10 f-pr10 f-tc">'
	+ msg.toString().replace('\n', '<br/>') + '</p><div class="f-mt15 f-mb20 f-tc">'
	+ '<button class="f-w40 btn btn_yellow f-fs16 f-pt10 f-pb10 fc-960e2a f-br5 cancel_btn">'+(window.language&&window.language['cancel'] || '取消')+'</button>\n'
	+ '<button class="f-w40 btn2 btn_red f-fs16 f-pt10 f-pb10 fc-fff f-br5 confirm_btn">'+(window.language&&window.language['confirm'] || '确认')+'</button></div></div>';
	document.body.appendChild(elem);
	var $elem = $(elem), $pop = $elem.find('.pop_in');
	$elem.fadeIn();
	$pop.css({"marginLeft": - $pop.outerWidth() / 2 + 'px', "marginTop": - $pop.outerHeight() / 2 + 'px'});
	elem.addEventListener('click', function(e){
		var target = e.srcElement || e.target;
		if (/confirm_btn/.test(target.className)) {
			$elem.fadeOut(function(){
				typeof callback === 'function' && callback();
				$elem.remove();
			});
		} else if (/cancel_btn/.test(target.className)) {
			$elem.fadeOut(function(){
				typeof cancel === 'function' && cancel();
				$elem.remove();
			});
		}
	}, false);
};

/**
 * 加载提示
 * @param {boolean} close 是否关闭弹层
 * @returns {undefined}
 */
msg.prototype.loading = function (msg, shade) {
	shade = typeof shade !== 'undefined' ? shade : false;
	++this.index;
	if (shade) {
		var shadeElem = document.createElement('div');
		shadeElem.id = 'shade-' + this.index;
		shadeElem.className = 'pop_bg';
		document.body.appendChild(shadeElem);
	}
	this.loadingElem = document.createElement('div');
	this.loadingElem.className = 'page_load hide';
	this.loadingElem.innerHTML = '<div class="page_load_img">' + (msg ? '<p class="page_load_p">' + msg.toString().replace('\n', '<br/>') + '</p>' : '') + '</div>';
	document.body.appendChild(this.loadingElem);
	var $elem = $(this.loadingElem).fadeIn();
	if (msg) {
		$elem.css('marginTop', - $elem.outerHeight() / 2 + 'px');
	}
	this.queue['item' + this.index] = this.loadingElem;
	return this.index;
};

msg.prototype.closeLoading = function (i) {
	if (!this.queue['item' + i]) {
		return;
	}
	var shadeElem = document.getElementById('shade-' + i);
	shadeElem && shadeElem.parentNode.removeChild(shadeElem);
	this.queue['item' + i].parentNode.removeChild(this.queue['item' + i]);
	delete this.queue['item' + i];
};



// RequireJS && SeaJS
if (typeof define === 'function') {
    define(function() {
        return new msg();
    });

// NodeJS
} else if (typeof exports !== 'undefined') {
    module.exports = new msg();
} else {
    this.msg = new msg();
}

})();
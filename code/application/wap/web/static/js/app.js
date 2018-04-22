function getCsrf() {
	return {name: $('meta[name=csrf-param]').attr('content'), value: $('meta[name=csrf-token]').attr('content')};
}

var scripts = document.getElementsByTagName('script'), scriptSrc = scripts[scripts.length - 1].src;
var arr = scriptSrc.split('/'), jsName = arr[arr.length - 1];
var staticUrl = scriptSrc.replace(jsName,'') + '..';

!(function ($) {

$.fn.bindLazyload = function() {
	return this.on('error', function(){
		this.src = staticUrl + '/img/noimg.jpg';
	}).scrollLoading();
};

/**
 * HTTP请求
 */
function _http() {
	this.version = "1.0.0";
	var self = this;
	this.callbackList = {
		before: function() {
			this.loadingTipIndex = msg.loading();
		},
		success: function(data) {
			self.handle(data);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if (self.csrf !== null && XMLHttpRequest.status === 400) {
				msg.warning('请勿重复提交数据');
			} else {
				msg.toast(self.getError(XMLHttpRequest.status, errorThrown));
			}
		},
		after: function() {
			msg.closeLoading(this.loadingTipIndex);
		}
	};
	this.init();
}

_http.prototype.init = function(){
	this.statusCodes = {'404':'请求的页面不存在'};
};

_http.prototype.getError = function(statusCode, errorThrown) {
	return typeof this.statusCodes[statusCode] !== 'undefined' ? this.statusCodes[statusCode] : (window.language&&window.language['network_error'] || '网络出错，请稍后再试') + ' [ E - ' + statusCode + ' ]';
};

_http.prototype.get = function(url, data, callbacks) {
	return this.load(url, data, 'get', callbacks);
};

_http.prototype.post = function(url, data, callbacks) {
	return this.load(url, data, 'post', callbacks);
};

_http.prototype.load = function (url, data, type, callbacks) {
	data = data || {};
	var self = this, callbackType = typeof callbacks;
	// 回调函数处理
	if (callbackType === 'function') {
		callbacks = $.extend({}, self.callbackList, {success: callbacks});
	} else if (callbackType === 'object') {
		callbacks = $.extend({}, self.callbackList, callbacks);
	} else {
		callbacks = self.callbackList;
	}
	type = type || 'GET';
	if (['GET', 'HEAD', 'OPTIONS'].indexOf(type.toUpperCase()) < 0) { // 部分请求拼接TOKEN
		self.csrf = getCsrf();
		var dType = typeof(data);
		if (dType === 'string') {
			if (data !== '') data += '&';
			data += self.csrf.name + '=' + self.csrf.value;
		} else if (data.length) {
			data.push({name:self.csrf.name,value:self.csrf.value});
		} else if (dType === 'object') {
			data[self.csrf.name] = self.csrf.value;
		}
	}
	return $.ajax({
		url: url,
		type: type,
		data: data || {},
		beforeSend: function () {
			typeof callbacks.before === "function" && callbacks.before.apply(this, arguments);
		},
		success: function () {
			typeof callbacks.success === "function" && callbacks.success.apply(this, arguments);
		},
		error: function () {
			typeof callbacks.error === "function" && callbacks.error.apply(this, arguments);
		},
		complete: function () {
			typeof callbacks.after === "function" && callbacks.after.apply(this, arguments);
		}
	});
};

/**
 * 请求返回JSON自动处理
 */
_http.prototype.handle = function (res) {
	if (typeof res === 'object') {
		if (res.status === 1) {
			if (res.info) {
				msg.toast(res.info, 1000, function(){
					if (res.url) location.href = res.url;
					else location.reload();
				});
			} else {
				if (res.url) location.href = res.url;
				else location.reload();
			}
		} else {
			msg.alert(res.info, function () {
				if (res.url) location.href = res.url;
			});
		}
		return;
	}
};

$.extend({http: new _http()});

if (typeof $.validator === 'undefined') return false;

var rules = {
	'email': /^\w+([-+.]\w+)*@\w+([-.]\w+)+$/i,
	'qq': /^[1-9][0-9]{4,}$/i,
	'id': /^\d{15}(\d{2}[0-9x])?$/i,
	'ip': /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/i,
	'zip': /^\d{6}$/i,
	'chinese': /^[\u4e00-\u9fa5]+$/,
	'mobile': /^1[34578]\d{9}$/,
	'phone': /^((\d{3,4})|\d{3,4}-)?\d{7,8}(-\d+)*$/i,
	'url': /^[a-zA-z]+:\/\/(\w+(-\w+)*)(\.(\w+(-\w+)*))+(\/?\S*)?$/i,
	'date': /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/i,
	'datetime': /^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29) (?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9])$/i,
	'int': /^\d+$/i,
	'float':/^\d+\.?\d*$/i,
	'number': /^\d+\.?\d*$/i
};
function getPattern(pattern) {
	if (typeof rules[pattern] !== 'undefined') {
		return rules[pattern];
	}
	return new RegExp(pattern);
}

$.validator.addMethod('pattern', function (value, element) {
	return (typeof element.pattern !== "undefined" && element.pattern !== "") ? this.optional(element) || (getPattern(element.pattern)).test(value) : true;
}, '请输入正确的值');

$.validator.addMethod('mt', function (value, element) {
	return this.optional(element) || value % parseFloat(element.getAttribute('mt')) === 0;
}, $.validator.format('请输入{0}的倍数'));

var _mv = function(callback1){
	return this.each(function () {
		var $this = $(this);
		if (typeof $this.data('binded') !== 'undefined') {
			return;
		}
		var errorElement = $this.data('error-element'), $errorElement = errorElement ? $(errorElement) : $('<div class="pop_cuo fc-fff f-tc f-fs16 f-br5 hide" style="bottom:30px;top:auto"></div>').appendTo($this), $btn = $(this.submitButton), loadingText = $btn.data('loading-text');
		var errorClass = 'validate-error';
		$this.data('bound', 'true').validate({
			errorClass: errorClass,
			showErrors: function(errorMap,errorList) {
//				this.defaultShowErrors();
//				this.valid();
				if (errorList.length) {
					$errorElement.stop().html(errorList[0].message).fadeIn();
					for(var i = 0; i < errorList.length; i++) {
						var $elem = $(errorList[i].element);
						if (!$elem.is(':checkbox') && !$elem.is(':radio') && !$elem.is('select')) {
							$elem.parent().find('.' + errorClass).remove();
							$elem.parent().append('<label id="' + errorList[i].element.name +  '-error" class="validate-error">!</label>');
						}
					}
				} else {
					$errorElement.stop().fadeOut();
					var elems = this.validElements();
					for(var i = 0; i < elems.length; i++) {
						var $elem = $(elems[i]);
						!$elem.is(':checkbox') && !$elem.is(':radio') && !$elem.is('select') && $elem.parent().find('.' + errorClass).remove();
					}
				}
			},
			submitHandler: function (form) {
				if (typeof(callback1) == 'function') return callback1.apply(this);
				if (typeof $this.data('ajax') !== 'undefined') { // 异步提交
					var events = $._data(form, 'events'), callback = {};
					callback.before = function() {
						this.loadingIndex = msg.loading(loadingText, true);
					};
					if (typeof (events['requestComplete']) !== 'undefined') {
						callback.success = function(data){
							$this.trigger('requestComplete', data);
						};
					}
					callback.after = function(){
						msg.closeLoading(this.loadingIndex);
					};
					$.http.load(form.action, $this.serialize(), form.method, callback);
				} else {
					form.submit();
				}
			}
		});
	});
};

$.fn.extend({myValidate:_mv});

$(function(){
	var $validateForms = $('form[data-ajax]:not([data-bound]),form[data-validate]:not([data-bound])');
	if ($validateForms.length) {
		$validateForms.myValidate();
	}
});

})(jQuery);

function pullRefresh(config) {
	var defaults = {up:{height:50,auto:!1,contentinit:"上拉显示更多",contentdown:"上拉显示更多",contentrefresh:window.language&&window.language['loading']||"正在加载...",contentnomore:window.language&&window.language['nomore']||"没有更多数据了",duration:300}};
	this.config = $.extend(true, defaults, config);
	this.noMore = false;
	this.loading = false;
	this.$container = $(this.config.container);
	var self = this;
	$(window).scroll(function () {
		if (!self.noMore && !self.loading) {
			var $window = $(this);
			if ($window.scrollTop() >= ($(document).height() - $window.height())) {
				self.pullupLoading();
				self.config.up.callback && self.config.up.callback.call(self);
			};
		}
	});
}
pullRefresh.prototype.reset = function(text) {
	this.noMore = false;
	this.$container.next('.load_nomore').remove();
}
pullRefresh.prototype.pullupLoading = function(text) {
	this.loading = true;
	this.$container.after('<div class="f-tc fc-666 f-fs15 f-pt10 f-pb10 f-lh18 load_div"><span class="load_img">' + (text || this.config.up.contentrefresh) + '</span></div>');
	
}
pullRefresh.prototype.endPullupToRefresh = function(noMore) {
	this.$container.next('.load_div').remove();
	this.loading = false;
	if (noMore) {
		this.noMore = true;
		this.$container.after('<div class="f-tc fc-666 f-fs15 f-pt10 f-pb10 f-lh18 load_nomore">' + this.config.up.contentnomore + '</div>');
	}
}
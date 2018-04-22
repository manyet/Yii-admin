;(function(factory){
  if (typeof define === "function" && define.amd) {
    //AMD
    define(["jquery"],factory);
  }else{
    factory(jQuery);
  }
}(function($){

"use strict";

var out = {}; // 输出的对象

/**
 * 页面跳转
 */
function _page() {
	this.urlList = [];
	this.urlIndex = 0;
}

_page.prototype.load = function (url) {
	location.hash = this.url = url;
	return true;
};

_page.prototype.back = function () {
	history.back();
};

_page.prototype.forward = function () {
	history.forward();
};

_page.prototype.reload = function () {
	window.onhashchange();
	return true;
};

_page.prototype.redirect = function (url) {
	this.urlList.push(url);
	this.urlIndex = this.urlList.length - 1;
	// 强制刷新
	if (location.hash.replace('#','') === url) {
		return this.reload();
	}
	return this.load(url);
};

_page.prototype.getHashUrl = function(){
	if (location.hash === '') {
		return '';
	}
	return location.hash.replace(/^#/, '');
};

_page.prototype.getQueryString = function(){
	var arr = this.getHashUrl().split('?');
	return arr[1] ? arr[1] : '';
};

_page.prototype.getUrlParam = function(key){
	var queryString = this.getQueryString();
	if (queryString) {
		var matchs = queryString.match(new RegExp('(^|&)' + key + '=' + '([^&]*)(&|$)'))
		if (matchs && matchs[2]) {
			return matchs[2];
		}
	}
	return null;
};

out.page = new _page();



/**
 * 消息提示
 */
function _msg() {
	this.version = "1.0.0";
	this.shade = false;
	this.index = 0;
	if (window.ActiveXObject || "ActiveXObject" in window) {
		this.loadingCircle = '<div class="loading"></div>';
		this.loadingCircle1 = '<div class="loading" style="width:26px;height:26px;left:0;margin-left:10px;margin-top:-13px;"></div>';
	} else {
		this.loadingCircle = '<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>';
		this.loadingCircle1 = '<div class="loader" style="width:30px;left:10px;right:auto"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg></div>';
	}
}

/**
 * 关闭指定弹窗
 * @param index
 */
_msg.prototype.close = function (index) {
	return layer.close(index || this.index);
};

_msg.prototype.alert = function (msg, callback) {
	return this.index = layer.alert(msg, callback);
};

/**
 * 错误弹窗
 * @param message
 */
_msg.prototype.error = function (msg, time, callback) {
	return this.index = layer.msg(msg || '操作错误', {time: time || 2000, icon: 2, shade: this.shade}, callback);
};

/**
 * 成功弹窗
 * @param message
 */
_msg.prototype.success = function (msg, time, callback) {
	return this.index = layer.msg(msg || '操作成功', {time: time || 1000, icon: 1, shade: this.shade}, callback);
};

/**
 * 警告弹窗
 * @param message
 */
_msg.prototype.warning = function (msg, time, callback) {
	return this.index = layer.msg(msg || '警告', {time: time || 1000, icon: 0, shade: this.shade}, callback);
};

/**
 * 确认框
 * @param message
 * @param yes   确定回调函数
 * @param no    取消回调函数
 */
_msg.prototype.confirm = function (msg, yes, no) {
	return this.index = layer.confirm(msg, {
		btn: ['确定', '取消'],
		shadeClose: true
	}, yes, no);
};

/**
 * 吐司提示
 */
_msg.prototype.toast = function (msg, during) {
	return this.index = layer.msg(msg, {time: during || 3000, shade: this.shade});
};

/**
 * 加载中提示
 */
_msg.prototype.loading = function (msg, callback) {
	var config = {
	  type: 1,
	  title: false,
	  closeBtn: 0,
	  scrollbar: false,
	  resize: false,
	  end: callback,
	};
	if (msg) {
		config.shade = 0.1;
		config.content = '<div style="padding:20px 20px 20px 50px;position:relative">' + this.loadingCircle1 + '<div>' + msg + '</div></div>';
		this.loadingIndex = layer.open(config);
	} else {
		config.shade = false;
		config.style = {boxShadow: 'none'};
		config.skin = 'layui-layer-nobg';
		config.content = '<div style="width:60px;height:60px;overflow: hidden;position: relative">' + this.loadingCircle +  '</div>';
		this.loadingIndex = layer.open(config);
		layer.style(this.loadingIndex, {boxShadow: 'none'});
	}
	return this.loadingIndex;
};

_msg.prototype.closeLoading = function (index) {
	return layer.close(index || this.loadingIndex);
};

/**
 * IFRAME层
 */
_msg.prototype.iframe = function (title, url, width, height) {
	var self = this;
//	$.http.get(url, {}, function(res){
		return layer.open({
			type: 2,
			title: title,
//			shadeClose: true,
//			shade: false,
			maxmin: true, //开启最大化最小化按钮
			area: [width || '893px', height || '600px'],
			content: url
		});
//	});
};

_msg.prototype.closeIframeByName = function(name) {
	var index = layer.getFrameIndex(name);
	return layer.close(index);
};

out.msg = new _msg();

/**
 * HTTP异步请求
 */
function _http() {
	this.version = "1.0.0";
	var self = this;
	this.callbackList = {
		before: function() {
			this.loadingTipIndex = $.msg.loading();
		},
		success: function(data) {
			self.handle(data);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if (self.csrf !== null && XMLHttpRequest.status === 400) {
				$.msg.warning('请勿重复提交数据');
			} else {
				$.msg.toast(self.getError(XMLHttpRequest.status, textStatus, errorThrown));
			}
		},
		after: function() {
			$.msg.closeLoading(this.loadingTipIndex);
		}
	};
	this.init();
}

_http.prototype.init = function(){
	this.statusCodes = {'404':'请求的页面不存在'};
};

_http.prototype.getError = function(statusCode, errorText, errorThrown) {
	return typeof this.statusCodes[statusCode] !== 'undefined' ?
		this.statusCodes[statusCode] :
		'网络出错，请稍后再试'+ (errorThrown ? '<br/>[ ' + errorThrown + ' ]' : '') + '<br/>[ ' + errorText + ' - ' + statusCode + ' ]';
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
		if (typeof window.onhashchange !== 'function') {
			if (res.status === 1) {
				out.msg.success(res.info, 1000, function(){
					if (res.url) location.href = res.url;
					else location.reload();
				});
			} else {
				out.msg.error(res.info, 2000, function () {
					if (res.url) location.href = res.url;
				});
			}
			return res.status === 1;
		}

		if (res.status === 1) {
			out.msg.success(res.info, 1000, function(){
				res.url ? $.page.redirect(res.url) : $.page.reload();
			});
		} else if (res.status === -1) {
			out.msg.warning(res.info, 1000, function(){
//				if (res.url) location.href = res.url + '?redirectURL=' + location.hash.replace('#', '');
				if (res.url) location.href = res.url + location.hash;
				else location.reload();
			});
		} else {
			out.msg.error(res.info, 2000, function () {
				res.url && $.page.redirect(res.url);
			});
		}
		return res.status === 1;
	}
	$.modal.render(res);
};

out.http = new _http();



var progressBar = {};
progressBar.create = function() {
	return this.obj = $('<div id="progress" class="progress active" style="z-index:9999;display:none;position: fixed;top:0;left:0;width: 100%;"><div class="progress-bar progress-bar-striped" role="progressbar" style="width:0%"><span>0%</span></div</div>').appendTo(document.body);
};
progressBar.getObj = function() {
	if (!this.obj) {
		return this.create();
	}
	return this.obj;
};
progressBar.show = function() {
	this.getObj().show();
};
progressBar.hide = function() {
	this.getObj().hide();
};
progressBar.progress = function(i, text) {
	this.getObj().children().css('width', i + '%').find('span').html(text || (i + '%'));
};

out.progressBar = progressBar;

/**
 * 模态框
 */
function _modal() {
	this.version = "1.0.0";
	this.index = 0;
	this.queue = [];
}

_modal.prototype.render = function(html) {
	var self = this, index = ++this.index;
	this.queue[index] = $(html).appendTo(document.body).on('shown.bs.modal',function(){
		var $this = $(this);
		$this.find('form[data-validate]').myValidate(function(data){
			if (typeof data === 'object') {
				data.status === 1 && self.close(index);
				$.http.handle(data);
				return;
			}
			$.msg.toast('页面请求错误，请稍候重试');
		});
		$this.find('[data-single-upload]').createSingleUpload();
		$this.find('[data-cropper-upload]').createCropperUpload();
	}).modal('show').on('hidden.bs.modal', function () {
		delete(self.queue[index]);
		$(this).remove();
	});
	return index;
};

_modal.prototype.load = function(url) {
	$.http.get(url, {}, function(res){
		$.http.handle(res);
	});
};

_modal.prototype.close = function(index) {
	index = index || this.index;
	this.queue[index].modal('hide');
	delete this.queue[index];
};

_modal.prototype.closeAll = function() {
	for(var i in this.queue) {
		this.close(i);
	}
};

out.modal = new _modal();



/**
 * 表单相关操作
 */
function _form() {
	this.version = "1.0.0";
}

_form.prototype.submit = function(form, callback){
	var $this = $(form), events = $._data(form, 'events'), callback = callback || {};
	if (typeof (events['requestComplete']) !== 'undefined') {
		callback.success = function(data){
			$this.trigger('requestComplete', data);
		};
	}
	$.http.load($this.attr('action'), $this.serializeArray(), $this.attr('method'), callback);
};

out.form = new _form();


window.url = {};
window.url.toRoute = function(path, params){
	var qSA=[],url=window.appPath+path+window.suffix;
	if (typeof params==="object") {
		for(var key in params){
			qSA.push(key+"="+params[key]);
		}
		if(qSA.length) url+='?'+qSA.join("&");
	}
	return url;
};

/**
 * 表格生成
 */
function _table() {
	this.version = "1.0.0";
	this.template = typeof template !== 'undefined' ? template : require('artTemplateNative');
	this.template.helper('parseFunction', function (funcStr, value, row, name, path, icon, className) {
		var funcArr = funcStr.split('|'), firstFunc = funcArr.shift(), str = eval(firstFunc + '(value,row,name,path,icon,className)');
		for (var i = 0; i < funcArr.length; i++) {
			str = eval(funcArr[i] + '(str)');
		}
		return str;
	});
}

_table.prototype.getId = function () {
	return this.id;
};

_table.prototype.getChecked = function () {
	var arr = [];
	$('#' + this.getId() + '>tbody').find('input:checked').each(function(){
		arr.push(this.value);
	});
	return arr;
};

_table.prototype.render = function (config, list) {
	this.id = config.id || 'table-' + (new Date()).valueOf()
	var tbArr = [], columns = config.columns, columnLen = columns.length, pk = config.pk || 'id';

	// 处理表格操作
	var operationsArr = config.operations || [];

	// 标题行排序列
	if (config.sort) {
		++columnLen;
		tbArr.push('<form onsubmit="return false;" data-validate data-ajax="true" data-progress="true" action="' + url.toRoute(module.controller + '/save-order') + '" method="post">');
	}

	// 标题行
	tbArr.push('<table id="' + this.id + '"' + (config.className ? ' class="my-table no-margin ' + config.className + '"' : '') + '><tbody><tr class="vertical-middle">');


	// 标题行选择列
	if (config.checkbox) {
		++columnLen;
		tbArr.push('<th class="table-col-checkbox"><input type="checkbox" data-check-all="' + this.id + '" data-check-name="' + config.checkbox + '[]"/></th>');
	}

	// 标题行排序列
	if (config.sort) {
		tbArr.push('<th class="table-col-order"><button class="btn btn-xs btn-success" title="数值越小，顺序越前"><i class="fa fa-sort"></i> 排序</button></th>');
	}

	for(var i = 0; i < columns.length; i++) {
		var halign = columns[i].halign || columns[i].align || 'center', widthStr = columns[i].width ? ' width="' + columns[i].width + '"' : '';
		tbArr.push('<th class="text-' + halign + '"' + widthStr + '>' + columns[i].title + '</th>');
	}

	// 标题行操作列
	if (operationsArr.length) {
		++columnLen;
		tbArr.push('<th class="text-center">操作</th>');
	}

	tbArr.push('</tr>');

	// 组装数据行
	var rowStyle = '';
	if (config.rowColor) {
		var colorFunc = config.rowColor.split('|');
		rowStyle = ' style="color:<%=parseFunction(\'' + colorFunc[1] + '\',list[j][\'' + colorFunc[0] + '\'])%>"';
	}
	var source = '<%for(var j=0;j<list.length;j++){%><tr class="vertical-middle"' + rowStyle + '>';

	// 数据行选择列
	if (config.checkbox) {
		source += '<td class="table-col-checkbox"><input type="checkbox" name="' + config.checkbox + '[]" value="<%=list[j]["' + pk + '"]%>"/></td>';
	}

	// 数据行排序列
	if (config.sort) {
		source += '<td class="table-col-order"><input type="text" name="' + config.sort + '[<%=list[j]["' + pk + '"]%>]" value="<%=list[j]["' + config.sort + '"]%>"/></td>';
	}

	if (list === null || !list.length) { // 没有数据
		tbArr.push('<tr><td align="center" colspan="' + columnLen + '" style="padding:30px 0">暂无相关记录</td></tr></tbody></table>');

		// 标题行排序列
		if (config.sort) {
			tbArr.push('</form>');
		}
		return tbArr.join('');
	}

	source += '<%for(var k=0;k<columns.length;k++){align = columns[k].align || "center"%>'
		+ '<td class="text-<%=align%>"><%=#columns[k].js?parseFunction(columns[k].js,list[j][columns[k].field],list[j],columns[k].title):list[j][columns[k].field]%></td>'
		+ '<%}%>';

	// 数据行操作列
	if (operationsArr.length) {
	   source += '<td class="text-center"><%for(var l=0;l<operations.length;l++){%><%=#parseFunction(operations[l].js,operations[l].key,list[j],operations[l].text,operations[l].path,operations[l].icon,operations[l].className)%><%}%></td>';
	}

	source += '</tr><%}%>';

	var render = this.template.render(source);
	tbArr.push(render({
		columns: columns,
		list: list,
		operations: operationsArr
	}));
	tbArr.push('</tbody></table>');
	
	// 标题行排序列
	if (config.sort) {
		tbArr.push('</form>');
	}
	return tbArr.join('');
};

out.table = new _table();

out.createDatePicker = function(start, end, config) {
	var defaults = {
		format: 'YYYY-MM-DD hh:mm:ss',
		istime: true,
		istoday: false
	};
	var startConfig = {};
	if (typeof start === 'string') {
		startConfig = $.extend({elem: start}, defaults, config);
		laydate(startConfig);
	}
	if (typeof end === 'string' && end != '') {
		var endConfig = $.extend({elem: end}, defaults, config), val = $(start).val(), endVal = $(end).val();
		if (val) endConfig.min = val;
		startConfig.choose = function (datas) {
			endConfig.min = datas;
		};
		if (endVal) startConfig.max = endVal;
		endConfig.choose = function (datas) {
			startConfig.max = datas;
		};
		laydate(endConfig);
	}
};

// 挂载方法到JQ
$.extend(out);




/* 扩展JQ对象方法 */
var myPager = function (config) {
	var self = this, c = {cont:self,pages:config.pageCount,curr:config.current,prev:'<',next:'>',first:'1',last:config.pageCount};
	c.jump = function(e, first){
		if (first) return;
		var url = config.url, rows = config.rows;
		$.page.redirect((new URI(url)).setParam({page:e.curr,rows:rows}).toURL());
	};
	require(['laypage'], function(laypage){
		laypage.dir = baseUrl + '/../css/laypage.css';
		laypage(c);
	});
	return this;
},
myValidate = function(callback){
	var myCallback = {
		after:function(){
			$.msg.closeLoading();
		}
	};
	if (typeof callback === 'function') myCallback.success = callback;
	return this.each(function(){
		var $this = $(this), errorElement = $this.data('error-element'), config = {
			submitHandler: function (form) {
//				var $btn = $this.find(':submit');
				var $btn = $(this.submitButton), tips = $btn.data('loading-text'), confirmText = $btn.data('confirm-text');
				myCallback.before = function(){
					$.msg.loading(tips || '保存中');
				};
				if (typeof confirmText !== 'undefined') {
					$.msg.confirm(confirmText || '确认要保存数据吗？', function () {
						$.msg.close();
						$.form.submit(form, myCallback);
					});
				} else {
					$.form.submit(form, myCallback);
				}
			}
		};
		if (errorElement) {
			var $errorElement = $(errorElement);
			config.showErrors = function(errorMap,errorList) {
//				this.defaultShowErrors();
				if (errorList.length) {
					$errorElement.stop().html(errorList[0].message).fadeIn();
				} else {
					$errorElement.stop().fadeOut();
				}
			};
//			config.errorElement = 'div';
//			config.errorContainer = errorElement;
//			config.errorLabelContainer = errorElement;
		} else {
			config.errorPlacement = function(error,element) {
				var $parent = element.parent();
				if ($parent.is('.checkbox')) {
					error.appendTo($parent.parent().parent());
				} else if ($parent.is('.radio') || $parent.is('.input-group')) {
					error.appendTo($parent.parent());
				} else {
					error.appendTo($parent);
				}
			}
		}
		$this.validate(config);
	}).data('bound', 'true');
};

$.createUploadSingleInput = function(callback) {
	return $('<input type="file" style="display:none" />').change(function(){

	if (!this.value) return;
	if (['jpg', 'png', 'jpeg', 'gif', 'bmp'].indexOf(this.value.substring(this.value.lastIndexOf('.') + 1).toLowerCase()) < 0) {
		$.msg.toast('不支持的文件类型');
		return;
	}
	var self = this;

	var xhr = null;
	if (window.XMLHttpRequest)
		xhr = new XMLHttpRequest();
	else if (window.ActiveXobiect)
		xhr = new ActiveXobiect('Microsoft.XMLHTTP');
	var formData = new FormData();
	var file = this.files[0];
//	var info = '文件名:' + file.name + ' 文件类型:' + file.type + ' 文件大小:' + file.size;
//	var showInfo = document.getElementById('showinfo');
//	var bar = document.getElementById('bar');
//	showInfo.innerHTML = info;
	formData.append('img', file);
	var csrf = getCsrf();
	formData.append(csrf.name, csrf.value);
	xhr.open('POST', url.toRoute('uploader/single-submit'), true);
	xhr.onreadystatechange = function () {
		if (this.readyState == 4)
		{
			progressBar.hide();
			self.value = '';
			if (this.status == 200) {
				try {
					var json = JSON.parse(this.responseText);
					if (json) {
						if (typeof callback === 'function') {
							callback.call(this, json);
						}
						return;
					}
				} catch(e){}
			}
			$.msg.toast('网络问题，图片上传失败');
		}
	};
	var schedule = 0;
	progressBar.show();
	progressBar.progress(0, '图片上传中：0%');
	xhr.upload.onprogress = function (d) {
		schedule = d.loaded / d.total * 100;
		schedule = schedule.toFixed(2);
		progressBar.progress(schedule, '图片上传中：' + schedule + '%');
	};
	xhr.send(formData);

	});
};

// 图片上传
var errorImg = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABLCAIAAAB7tddWAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1Q0VBNzA0MjEyMDUxMUUzODk2Q0JFM0Q1RjE4QkExQyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1Q0VBNzA0MzEyMDUxMUUzODk2Q0JFM0Q1RjE4QkExQyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjAzNDA2MkY1MTIwMzExRTM4OTZDQkUzRDVGMThCQTFDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjAzNDA2MkY2MTIwMzExRTM4OTZDQkUzRDVGMThCQTFDIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+K6izdgAAAvpJREFUeNrsnFmPqkAQhWmX667gEp9c/v+/MkSDG+4LrvdcSYgRbw/0ALZQ9WBUJOn+uqvqHGCG3e93hUJRUoSAQBAIAkEgCASBIBAE4neRicEcII51Xb/dbnjPGOt0OqlUKok7ApN3jIKwY6DUIBAEgkAQCALho/X47TeXy8U0TcuyrtdrZKPs9/v2m8FgINYgf9QX/gTV+Xw2DCNKBJKmxmKxsAVc0kEcDgfyGq8CNp/Pa5qWy+WiHG6v13v7/XPt6Ha7Al5D3HQ1Go1sNkvtU8lkMsmtESSoCASBSFqEW/DQ0tbr9W63O51OKK6FQkFV1XQ6nSwQ0OOTyQSvjknZbDaA0mq1QCQafSFFasxmM4eCE1Do0+lUQrcSFggsPhzq20NgsVqtkpIax+MxMs+C/aXruvMxaonND75J9W5hUWWxuYAVdRfTg8EplUphGJywQPAFuBd5Dlhw/aDwwgVtCDgCdzph1QisG+dosVjkn44WYxjGC4XnvBuNRtvt9gtA2Hv47SGsZKVS4ef8eDzG4vMVCrpSgEU3xPbZbDar1erLl1AQ7XabU8xAAXvB3XffBnIHwkR2QcUYq9fr5XIZOxkTg6BEkeNLKdQF7AWPFBy1AoUmu8RG/HmE91nxM+J/ORIr07VcLvf7feCt+stAQGIBRNJtOJolDAhdj/hXGj5+u+TzIKAF+MbkK00XFta2BhDRUE0/9gv8Elogbu4TBW8+nyPhHSeuaVqtVuNQC6TzyQUCXsg0TbfyAxfIKogr9ynP1GJyYQZ57qbg7AuIRfclKZwSlDqWBQSmxM9zFALYh+fFBwJJSkNgqeFxSrAPw+EQ9QJew7Is2Sj8FgSW2nu1gylYPkKRMsRTA+4IcjA2fxsnDkLOq/IfACFP54uP1yAQBIJAEIh4gWCPkHk+GJ7AjU/fICJ+qlIghEfoDwQMtRjvyLYDRih4rsDT+bBM9tP5kuhrzN++e6SqqvCdYUb/SIO6BoEgEASCQBAIAkEgCEQg8VeAAQAB1bbO2qoeewAAAABJRU5ErkJggg==';

$.fn.createSingleUpload = function() {

return this.each(function(){
	var $this = $(this);

	var img = document.createElement('img');
	img.src = this.value || errorImg;
	img.id = $this.data('single-upload') || this.name + '-img-' + Math.random().toString().substring(4, 10);
	img.style.width = $this.data('width') || '150px';
	img.style.height = $this.data('height') || '150px';
	img.style.backgroundColor = '#fff';
	img.style.border = '1px solid #ddd';
	img.style.cursor = 'pointer';
	img.className = 'upload-single';

	var $file = $.createUploadSingleInput(function(json){
		if (json.status === 1) {
			$.msg.toast(json.info);
			$this.val(json.url).change();
			img.src = json.url;
//			showInfo.innerHTML = showInfo.innerHTML + '<br />' + this.responseText;
		} else {
			$.msg.toast(json.info);
		}
	});
			
	$this.after($file);
	$(img).on('click', function() {
		$file.click();
	}).on('error', function() {
		this.src = errorImg;
	}).insertAfter(this);
});

};

$.fn.createCropperUpload = function () {
	return this.each(function(){
		var $this = $(this);
		var img = document.createElement('img');
		img.src = this.value || errorImg;
		img.width = $this.attr('width') || 150;
		img.height = $this.attr('height') || 150;
		img.id = $this.data('cropper-upload') || this.name + '-img-' + Math.random().toString().substring(4, 10);
		img.style.backgroundColor = '#fff';
		img.style.border = '1px solid #ddd';
		img.style.borderRadius = '5px';
		img.style.cursor = 'pointer';
		img.className = 'upload-cropper';
		$(img).on('click', function() {
			$.modal.load(url.toRoute('uploader/cropper', {url: $this.data('handle-url') || '', id: img.id, width: img.width, height: img.height}));
		}).on('error', function() {
			this.src = errorImg;
		}).insertAfter(this);
	});
}

$.fn.extend({
	myPager: myPager,
	myValidate: myValidate
});

/*绑定表单验证*/
$('form[data-validate]').myValidate();

$.fn.createEditor = function(config) {

var self = this;

require(['zeroclipboard', 'ueditor'], function(b){
	window.ZeroClipboard = b;
	UE.registerUI('uimage', function (editor, uiName) {
        var btn = new UE.ui.Button({
            name: uiName,
            title: '单图上传',
            cssRules: 'background-position: -380px 0px;',
            onclick: function () {
				if (!this.$uploadInput) {
					this.$uploadInput = $.createUploadSingleInput(function(d){
						if (d.status === 1) {
							var srcs = d.url.split('|'), data = new Array();
							for (var i in srcs) {
								data.push({src: srcs[i]});
							}
							editor.execCommand('insertimage', data);
						} else {
							$.msg.toast(d.info);
						}
					});
				}
				this.$uploadInput.click();
            }
        });
        editor.addListener('selectionchange', function () {
            var state = editor.queryCommandState(uiName);
            if (state === -1) {
                btn.setDisabled(true);
                btn.setChecked(false);
            } else {
                btn.setDisabled(false);
                btn.setChecked(state);
            }
        });
        return btn;
    });
    /*UE.registerUI('umimage', function (editor, uiName) {
        var btn = new UE.ui.Button({
            name: uiName,
            title: '多图上传',
            cssRules: 'background-position: -726px -77px;',
            onclick: function () {
                var field = '_editor_upload_' + Math.floor(Math.random() * 100000);
                var url = window.APP_URL + '/plugs/file/index.html?uptype=qiniu&type=image&field=' + field;
                $('<input type="hidden">').attr('name', field).appendTo(editor.container).on('change', function () {
                    var srcs = this.value.split('|');
                    setTimeout(function () {
                        for (var i in srcs) {
                            var data = new Array();
                            data.push({src: srcs[i]});
                            editor.execCommand('insertimage', data);
                        }
                    }, 100);
                    $(this).remove();
                });
                $.form.iframe(url, '插入多张图片');
            }
        });
        editor.addListener('selectionchange', function () {
            var state = editor.queryCommandState(uiName);
            if (state === -1) {
                btn.setDisabled(true);
                btn.setChecked(false);
            } else {
                btn.setDisabled(false);
                btn.setChecked(state);
            }
        });
        return btn;
    });*/
	self.each(function(){
		var id = '_ueditor_id_' + Math.floor(Math.random() * 100000000);
		$(this).attr('id', id).data('editor', UE.getEditor(id, {
			zIndex: 90000,
	//		topOffset: 50,
			wordCount: false,
			maxInputCount: 0,
			minFrameHeight: 250,
			enableAutoSave: false,
			autoFloatEnabled: true,
			autoHeightEnabled: false,
			initialFrameWidth: null,
	//		initialFrameHeight: 200,
			elementPathEnabled: false,
			catchRemoteImageEnable: false,
			toolbars: [[
				'source', //源代码
				'undo', //撤销
				'redo', //重做
				'fontfamily', //字体
				'fontsize', //字号
				'paragraph', //段落格式
				'bold', //加粗
				'italic', //斜体
				'underline', //下划线
				'forecolor', //字体颜色
				'backcolor', //背景色
				'indent', //首行缩进
				'justifyleft', //居左对齐
				'justifyright', //居右对齐
				'justifycenter', //居中对齐
				'justifyjustify', //两端对齐
				'formatmatch', //格式刷
				'autotypeset', //自动排版
				'uimage', //单图上传
				'umimage', //单图上传
				'removeformat', //清除格式
				'link', //超链接
				'unlink', //取消链接
				'emotion', //表情
				'map', //Baidu地图
				'imagenone', //默认
				'imageleft', //左浮动
				'imageright', //右浮动
				'imagecenter', //居中
				'lineheight', //行间距
				'scrawl', //涂鸦
				'inserttable' //插入表格
			]]
		}));
	});
//	$('.animated').removeClass('animated');
});

};

$.fn.createClipboard = function() {

var self = this;
require(['zeroclipboard'], function(ZeroClipboard){
	ZeroClipboard.config({
        swfPath: pluginUrl + '/zeroclipboard/ZeroClipboard.swf'
	});

	self.each(function(){
		if (ZeroClipboard.isFlashUnusable()) {
			var $this = $(this);
			$this.click(function(e){
				e.preventDefault();
				var target = $this.data('clipboard-target'), content = '';
				if (target) {
					content = $('#' + target).html();
				}
				content = content || $this.data('clipboard-text');
				var $con = $('<div style="padding:10px; width: 300px">您的浏览器不支持复制，请按Ctrl+C进行复制<br/><textarea rows="5" style="width:100%">' + content + '</textarea></div>').appendTo('body');
				layer.open({
					type: 1,
					title: false,
					closeBtn: 0,
					shadeClose: true,
					content: $con,
					end: function () {
						$con.remove();
					}
				  });
				  $con.find('textarea').select();
				  
			});
		} else {
			var client = new ZeroClipboard(this);
			client.on("ready", function () {
				client.on("aftercopy", function () {
					$.msg.toast('复制成功');
				});
			});
		}
	});
});

};

/*!
* jQuery placeholder, fix for IE6,7,8,9
*/
var JPlaceHolder = {
   _check: function () {
	   return 'placeholder' in document.createElement('input');
   },
   init: function () {
	   !this._check() && this.fix();
   },
   fix: function () {
	   $(':input[placeholder]').map(function () {
		   var self = $(this), txt = self.attr('placeholder');
		   self.wrap($('<div></div>').css({position: 'relative', zoom: '1', border: 'none', background: 'none', padding: 'none', margin: 'none'}));
		   var pos = self.position(), h = self.outerHeight(true), paddingleft = self.css('padding-left');
		   var holder = $('<span></span>').text(txt).css({position: 'absolute', left: pos.left, top: pos.top, height: h, lineHeight: h + 'px', paddingLeft: paddingleft, color: '#aaa'}).appendTo(self.parent());
		   self.on('focusin focusout change keyup', function () {
			   self.val() ? holder.hide() : holder.show();
		   });
		   holder.click(function () {
			   self.get(0).focus();
		   });
		   self.val() && holder.hide();
	   });
   }
};
JPlaceHolder.init();

}));
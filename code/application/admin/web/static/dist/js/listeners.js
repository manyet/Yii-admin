;(function(factory){
  if (typeof define === "function" && define.amd) {
    define(["jquery"],factory);
  }else{
    factory(jQuery);
  }
}(function($){

"use strict";

$(document.body).on('click', '[data-logout]', function (e) {
	e.preventDefault();
	$.msg.loading('退出登录中');
	$.get($(this).data('logout'),function(res){
		location.href = res.url + location.hash;
	}, 'json');
}).on('click', '[data-href]', function (e) {
	e.preventDefault();
	var url = $(this).data('href');
	var uri = new URI(url);
	uri.setParam('spm', menu.getActiveNode().data('menu-spm'));
	$.page.redirect(uri.toURL());
}).on('click', '[data-prompt]', function (e) {
	e.preventDefault();
	var $this = $(this);
	layer.prompt({title: $this.data('title'), formType: $this.data('type') || 0, value: $this.data('value') || ''}, function(value, index){
		$.http.post($this.data('prompt'), {value: value}, function(d){
			if ($.http.handle(d)) {
				layer.close(index);
			}
		});
	});
}).on('click', '[data-load]', function (e) {
	e.preventDefault();
	var $this = $(this), confirmText = $this.data('confirm-text');
	if (confirmText) {
		$.msg.confirm(confirmText, function() {
			$.msg.close();
			$.http.get($this.data('load'));
		});
	} else {
		$.http.get($this.data('load'));
	}
}).on('click', '[data-modal]', function (e) {
	e.preventDefault();
	$.modal.load($(this).data('modal'));
}).on('click', '[data-change-status]', function (e) {
	e.preventDefault();
	var $_self = $(this);
	$.msg.confirm('确定要更改数据状态？', function(){
		$.msg.close();
		$.http.post($_self.data('change-status'), {id: $_self.data('id') || '', status: $_self.data('status') || '0'},{
			before: function(){
				this.loadingIndex = $.msg.loading('数据状态更改中');
			},
			after: function(){
				$.msg.closeLoading(this.loadingIndex);
			}
		});
	});
}).on('click', '[data-del]', function (e) {
	e.preventDefault();
	var $_self = $(this), id = $_self.data('id'), text = '确定删除该数据？';
	if (!id) {
		id = $.table.getChecked();
		if (!id.length) {
			$.msg.toast('请选择要操作的数据');
			return;
		}
		text = '确定删除选择的数据？';
	}
	$.msg.confirm(text, function () {
		$.msg.close();
		$.http.post($_self.data('del'), {id: id}, {
			before: function(){
				this.loadingIndex = $.msg.loading('数据删除中');
			},
			after: function(){
				$.msg.closeLoading(this.loadingIndex);
			}
		});
	});
}).on('click', '[data-multiple]', function (e) {
	e.preventDefault();
	var id = $.table.getChecked();
	if (!id.length) return;
	var $_self = $(this), other = $_self.data('other'), data = {};
	if (other) {
		other = other.split(',');
		for (var i = 0; i < other.length; i++) {
			var tmp = other[i].split(':');
			data[tmp[0]] = tmp[1];
		}
	}
	data.id = id;
	$.http.post($_self.data('multiple'), data);
}).on('click', '[data-open]', function (e) {
	e.preventDefault();
	window.open($(this).data('open'));
}).on('click', '[data-iframe]', function(e){
	e.preventDefault();
	var $this = $(this);
	$.msg.iframe($this.data('iframe-title') || this.innerText, $this.data('iframe'), $this.data('iframe-width'), $this.data('iframe-height'));
}).on('click', '[data-thumb]', function() {
	var i = $.msg.loading();
	var $this = $(this), maxWidth = $this.data('max-width'), maxHeight = $this.data('max-height');
	$('<img src="' + ($(this).data('thumb') || this.src) + '"/>').on('load', function(){
		var owidth = this.width, oheight = this.height, area;
		if (maxWidth && owidth > maxWidth) {
			this.width = maxWidth;
			area = maxWidth + 'px';
		} else {
			area = owidth + 'px';
		}
		if (maxHeight && oheight > maxHeight) {
			this.height = maxHeight;
			area = [maxHeight * owidth / oheight + 'px'];
		}
		$.msg.close(i);
		layer.open({type: 1, area: area, shadeClose: true, title: false, content: this.outerHTML});
	});
}).on('click', '[data-wechat-view]', function () {
	var src = this.getAttribute('data-wechat-view') || this.href,
		$container = $('<div class="phone-container hide"><img src="'+window.webRoot+'static/dist/img/wechat-head.png" style="width:100%"/><div class="phone-screen"><iframe frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div>').appendTo('body');
	$container.find('iframe').attr('src', src);
	$container.find('img').on('click', function () {
		history.back();
	});
	var index = layer.open({
		type: 1, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: 1, resize: false, skin: 'layui-layer-nobg', shadeClose: true,
		content: $container.removeClass('hide'),
		end: function () {
			$container.remove();
		}
	});
	layer.style(index, {boxShadow: 'none'});
});

/* 页面容器 */
var $container = $('#page-container').on('submit', 'form[data-search]', function (e) { // 表单提交搜索
	e.preventDefault();
	var $this = $(this), data = $this.serialize(), action = $this.attr('action');
	$.page.redirect(action + (action.indexOf('?') > -1 ? '&' : '?') + data);
}).on('click', '[data-search-submit]', function (e) { // 自定义搜索按钮提交搜索
	e.preventDefault();
	var $this = $(this), selector = $this.data('search-submit'),
	$form = selector ? $(selector) : $this.closest('form[data-search]');
	$form.submit();
}).on('change', 'form[data-search] select', function (e) {
	e.preventDefault();
	$(this).closest('form[data-search]').submit();
}).on('click', '[data-check-all]', function(){ // 全选按钮
	var $this = $(this);
	$('#' + $this.data('check-all')).find('input[name="'+ $this.data('check-name') +'"]').prop('checked', this.checked);
});

var first = true;
/* 监听哈希地址变化 */
window.onhashchange = function () {
	var url = $.page.getHashUrl();
	if (first && !url.length) { // 默认打开第一个菜单
		menu.$leftContainer.find('[data-open-page]:first').trigger('click');
		return;
	}
	var spm = $.page.getUrlParam('spm'), $li;
	if (spm) {
		$li = menu.$leftContainer.find('[data-menu-spm="' + spm + '"]');
	} else {
		$li = menu.$leftContainer.find('[data-open-page*="'+url.split('?')[0]+'"]').parent();
	}
	// 选中当前菜单
	$li.length && menu.setActive($li);
	if (!url.length) return;
	/* 加载资源 */
	$.http.get(url, {}, {
		before: function() {
			!first && Pace.restart();
		},
		after: null,
		success: function(html) {
			if (typeof html === 'object') {
				$.http.handle(html);
				return;
			}
			$container.html(html);
			$container.find('form[data-validate]').myValidate();
			$container.find('[data-single-upload]').createSingleUpload();
			$container.find('[data-cropper-upload]').createCropperUpload();
		},
		error: function(a, b, c) {
			$container.html('<section class="content"><div class="box"><div class="box-body with-border animated fadeInUp"><div style="padding:100px 0;text-align:center"><i class="fa fa-times-circle text-danger" style="font-size:50px;margin-bottom:10px"></i><div style="font-size:20px">'
				+ $.http.getError(a.status, b, c)
				+ '</div><a href="javascript:$.page.reload()">刷新</a><i class="text-explode"></i><a href="javascript:$.page.back()">返回</a></div></div></div></section>');
		}
	});
};

window.onhashchange();

first = false;

}));
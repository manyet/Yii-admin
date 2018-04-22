function getOperationButton(name, data, icon, className){
	var tmp = ['<a class="table-operation' + (className ? ' ' + className : '') + '"'];
	data = data || {};
	if (!data.href) data.href = "javascript:;";
	for (var i in data) {
		tmp.push(' ' + i + '="' + data[i] + '"');
	}
	tmp.push('>' + (icon?'<i class="'+icon+'"></i> ':'') + name + '</a><i class="text-explode"></i>');
	return tmp.join('');
}
function showButton(key, row, name, path, icon, className, type){
    return '<a  class="table-operation '+className+'" data-'+type+'="'+url.toRoute(path,{id:row[key]})+'">'+(icon?' ':'')+name+'</a><i class="text-explode"></i>';
}
function getHrefButton(key, row, name, path, icon, className) {
	return getOperationButton(name, {'data-href': url.toRoute(path,{id:row[key]})}, icon, className);
}

function getLoadButton(key, row, name, path, icon, className) {
	return getOperationButton(name, {'data-load': url.toRoute(path,{id:row[key]})}, icon, className);
}

function getModalButton(key, row, name, path, icon, className) {
	return getOperationButton(name, {'data-modal': url.toRoute(path,{id:row[key]})}, icon, className);
}

/**
 * 显示编辑按钮
 */
function getEditButton(key, row, name, path, icon, className) {
	return getOperationButton(name, {'data-modal': url.toRoute(path,{id:row[key]})}, icon, className);
}

/**
 * 显示删除按钮
 */
function getDelButton(key, row, name, path, icon, className) {
	return getOperationButton(name, {'data-del': url.toRoute(path), 'data-id': row[key]}, icon, className + ' text-danger');
}

/**
 * 禁用或启用按钮
 */
function getToggleButton(key, row, name, path) {
	var tmp = key.split(','), data = {'data-id': row[tmp[1] || 'id'], 'data-change-status': url.toRoute(path)};
    switch (parseInt(row[tmp[0]])){
        case 0:
			data['data-status'] = 1;
			return getOperationButton('启用', data);
        case 1:
			data['data-status'] = 0;
			return getOperationButton('禁用', data);
    }
}

/**
 * 禁用或启用按钮
 */
function getReleaseButton(key, row, name, path) {
    var tmp = key.split(','), data = {'data-id': row[tmp[1] || 'id'], 'data-change-status': url.toRoute(path)};
    switch (parseInt(row[tmp[0]])){
        case 0:
            data['data-status'] = 1;
            return getOperationButton('发布', data);
        case 1:
            data['data-status'] = 0;
            return getOperationButton('发布', data);
    }
}

/**
 * 显示状态
 */
function showStatus(status) {
    switch (parseInt(status)) {
        case 0:
            return '<i class="fa fa-ban text-warning"></i>';
        case 1:
            return '<i class="fa fa-check text-success"></i>';
    }
}

function showThumb(src) {
	return '<img src="' + src + '" class="thumb" data-thumb onerror="this.src=\'' + window.webRoot + 'static/dist/img/default.png\'" />';
}

/**
 * 时间戳转日期格式
 * @param time
 * @returns {string}
 */
function showDate(time) {
    if (parseInt(time) === 0){
        return '';
    }
    var pad = function (n, c) {
        if ((n = n + "").length < c) {
            return new Array(++c - n.length).join("0") + n;
        } else {
            return n;
        }
    };
    var date = (time) ? new Date(parseInt(time) * 1000) : '';
    if (date.length === 0) {
        return false;
    }

    return date.getFullYear() + '-' + pad(date.getMonth() + 1, 2) + '-' + pad(date.getDate(), 2) + ' ' + pad(date.getHours(), 2) + ':' + pad(date.getMinutes(), 2) + ':' + pad(date.getSeconds(), 2)
}
/**
 * 金钱数字格式化
 */
function moneyFormat(s, n) {  
	n = n > 0 && n <= 20 ? n : 2;  
	s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";  
	var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1],t = "";  
	for (var i = 0; i < l.length; i++) {  
		t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");  
	}  
	return t.split("").reverse().join("") + "." + r;  
}

/**
 * URL转URI对象
 * @param {String} url
 * @returns {URI}
 */
function URI(url){
	this.parmasLength = 0;
	this.url = url;
	this.parse();
};
URI.prototype.parse = function(){
	var tmp = this.url.split('#'), uri = {};
	// 锚记
	if (tmp[1]) {
		uri.fragment = tmp[1];
	}else{
		uri.fragment = "";
	}
	uri.params = {};
	// 查询字符串
	tmp = tmp[0].split('?');
	if (tmp[1]) {
		var p = tmp[1].split('&');
		for(var i in p){
			if (!p[i]) continue;
			this.parmasLength++;
			var t = p[i].split('=');
			uri.params[t[0]] = t[1] || '';
		}
	}
	uri.path = tmp[0];
	this.uri = uri;
	return this;
};
URI.prototype.setParam = function(key, value) {
	if (typeof key === 'object') {
		for(var i in key){
			if (!this.uri.params[i]) this.parmasLength++;
			this.uri.params[i] = key[i];
		}
	} else {
		if (!this.uri.params[key]) this.parmasLength++;
		this.uri.params[key] = value;
	}
	return this;
};
URI.prototype.removeParam = function(key) {
	if (this.uri.params[key]) {
		delete this.uri.params[key];
		this.parmasLength--;
	}
	return this;
};
URI.prototype.toURL = function(){
	var sb = new stringBuilder(), query = '';
	if (this.parmasLength) {
//	if (JSON.stringify(this.uri.params) !== "{}") {
		for(var i in this.uri.params){
			sb.append(i+'='+this.uri.params[i]);
		}
		query += '?' + sb.toString('&');
	}
	return this.uri.path+query+(this.uri.fragment?'#'+this.uri.fragment:'');
};

/**
 * 字符串构建器
 * @returns {stringBuilder}
 */
function stringBuilder() {
	this.tmp = [];
}
stringBuilder.prototype.append = function(str){
	this.tmp.push(str);
};
stringBuilder.prototype.toString = function(split){
	return this.tmp.join(split || '');
};


!(function () {

var helper = {};

helper.moneyFormat = function(s, n) {  
	n = n > 0 && n <= 20 ? n : 2;  
	s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";  
	var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1],t = "",i;  
	for (i = 0; i < l.length; i++) {  
		t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");  
	}  
	return t.split("").reverse().join("") + "." + r;  
};

helper.getUrlParam = function (name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"),r = null;
	if ((r=window.location.search.substr(1).match(reg)) !== null) {
		return unescape(r[2]);
	}
	return null;
};

/**
 * 时间戳转日期格式
 * @param time
 * @returns {string}
 */
helper.dateFormat = function (date,format) {
	if (date === 0 || date.length === 0){
		return false;
	}
	if (typeof date === "string") {
		var mts = date.match(/(\/Date\((\d+)\)\/)/);
		if (mts && mts.length >= 3) {
			date = parseInt(mts[2]);
		}
	}
	date = new Date(date);
	if (!date || date.toUTCString() == "Invalid Date") {
		return "";
	}

	var map = {
		"M": date.getMonth() + 1, //月份
		"d": date.getDate(), //日
		"h": date.getHours(), //小时
		"m": date.getMinutes(), //分
		"s": date.getSeconds(), //秒
		"q": Math.floor((date.getMonth() + 3) / 3), //季度
		"S": date.getMilliseconds() //毫秒
	};


	format = format.replace(/([yMdhmsqS])+/g, function(all, t){
		var v = map[t];
		if(v !== undefined){
			if(all.length > 1){
				v = '0' + v;
				v = v.substr(v.length-2);
			}
			return v;
		}
		else if(t === 'y'){
			return (date.getFullYear() + '').substr(4 - all.length);
		}
		return all;
	});
	return format;
};



// RequireJS && SeaJS
if (typeof define === 'function') {
    define(function() {
        return helper;
    });

// NodeJS
} else if (typeof exports !== 'undefined') {
    module.exports = helper;
} else {
    this.helper = helper;
}

})();
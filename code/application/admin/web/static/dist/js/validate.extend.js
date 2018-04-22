!(function (factory) {
    if (typeof define === "function" && define.amd) {
        // AMD模式
        define([ "jquery", "validate" ], factory);
    } else {
        // 全局模式
        factory(jQuery);
    }
}(function ($) {

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
$.extend($.validator.messages,{required:"这是必填字段",remote:"请修正此字段",email:"请输入有效的电子邮件地址",url:"请输入有效的网址",date:"请输入有效的日期",dateISO:"请输入有效的日期 (YYYY-MM-DD)",number:"请输入有效的数字",digits:"只能输入数字",creditcard:"请输入有效的信用卡号码",equalTo:"你的输入不相同",extension:"请输入有效的后缀",maxlength:$.validator.format("最多可以输入 {0} 个字符"),minlength:$.validator.format("最少要输入 {0} 个字符"),rangelength:$.validator.format("请输入长度在 {0} 到 {1} 之间的字符串"),range:$.validator.format("请输入范围在 {0} 到 {1} 之间的数值"),max:$.validator.format("请输入不大于 {0} 的数值"),min:$.validator.format("请输入不小于 {0} 的数值")});

}));
var a = document.scripts, c = a[a.length - 1].src, baseUrl = c.substring(0, c.lastIndexOf("/")),
		pluginUrl = baseUrl.substring(0, baseUrl.lastIndexOf("/"));

pluginUrl = pluginUrl.substring(0, pluginUrl.lastIndexOf("/")) + "/plugin";

window.UEDITOR_HOME_URL = pluginUrl + '/ueditor/';

requirejs.config({
//	urlArgs: "v=" + (new Date()).getTime(),
	baseUrl: baseUrl,
	map: {
		"*": {
			"css": pluginUrl + "/require/require.css.js"
		}
	},
	paths: {
		"jquery": "jquery-define",
		"jquery-ui": pluginUrl + "/jQueryUI/jquery-ui.min",
		"plugins": "plugins",
		"helpers": "helpers",
		"listeners": "listeners",
		"validateExtend": "validate.extend",
		"validate": pluginUrl + "/validate/jquery.validate.min",
		"metadata": pluginUrl + "/metadata/jquery.metadata",
		"layer": pluginUrl + "/layer/layer",
		"laypage": pluginUrl + "/laypage/laypage",
		"artTemplate": pluginUrl + "/artTemplate/template",
		"artTemplateNative": pluginUrl + "/artTemplate/template-native",
		"ztree": pluginUrl + "/ztree/js/jquery.ztree.all",
		"webuploader": pluginUrl + "/uploader/js/webuploader",
		"webuploader.flashonly": pluginUrl + "/uploader/js/webuploader.flashonly.min",
		"dataTables": pluginUrl + "/datatables/jquery.dataTables.min",
		"dataTables.bootstrap": pluginUrl + "/datatables/dataTables.bootstrap.min",
		"dataTables.responsive": pluginUrl + "/datatables/extensions/Responsive/js/dataTables.responsive.min",
		"uploader-single": "uploader-single", // 图片上传
		"cropper": pluginUrl + "/cropper/cropper.min", // 裁剪图片
		"html2canvas": pluginUrl + "/html2canvas.min",
		"masonry": pluginUrl + "/masonry.min",
		"ueditor": pluginUrl + "/ueditor/ueditor.all.min",
		"zeroclipboard": pluginUrl + "/zeroclipboard/ZeroClipboard.min",
	},
	shim: {
		"ueditor": [pluginUrl + "/ueditor/ueditor.config.js", "zeroclipboard"],
		"listeners": ["plugins"],
		"plugins": ["helpers", "layer", "validateExtend", "artTemplateNative", "css!../css/table.css"],
		"validate": "jquery",
		"layer": {
			deps: ["css!" + pluginUrl + "/layer/skin/default/layer.css"],
			exports: "layer"
		},
		"ztree": ["jquery", "css!" + pluginUrl + "/ztree/css/zTreeStyle/zTreeStyle.css"],
		"dataTables": [
			"jquery",
			"css!" + pluginUrl + "/datatables/jquery.dataTables.min.css"
		],
		"dataTables.bootstrap": [
			"css!" + pluginUrl + "/datatables/dataTables.bootstrap.css",
			"dataTables"
		],
		"dataTables.responsive": [
			"css!" + pluginUrl + "/datatables/extensions/Responsive/css/dataTables.responsive.css",
			"dataTables"
		],
		"cropper": [
			"css!" + pluginUrl + "/cropper/cropper.min.css"
		],
		"uploader-single": [
			"css!" + baseUrl + "/../css/uploader-single.css",
			"cropper",
			"html2canvas"
		]
	},
	waitSeconds: 0
});

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('role/access-refresh')) { ?>
<a class="btn btn-xs btn-success" title="刷新权限节点" data-load="<?= \yii\helpers\Url::toRoute('access-refresh') ?>">
	<i class="glyphicon glyphicon-refresh"></i> 刷新节点
</a>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<form id="auth-form" class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute('role/access-save') ?>" onsubmit="return false">
	<div style="padding:50px 0;text-align:center;font-size:30px" id="access-spinner">
		<i class="fa fa-spin fa-spinner"></i>
	</div>
	<ul class="ztree" id="auth-container" style="overflow-y:scroll"></ul>
	<div id="btns" style="display:none">
		<button class="btn btn-sm btn-primary btn-flat">保存</button>
		<button class="btn btn-sm btn-flat" type="button" data-href="<?= \yii\helpers\Url::toRoute('role/index') ?>">返回</button>
	</div>
</form>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<style>
.ztree{padding:0;font-weight:bold}
.ztree>li{border-bottom:1px solid #ebebeb;margin-bottom:15px;padding-bottom:8px}
.ztree li{padding-top:8px !important}
.ztree ul:after{display:block;content:'';clear:both}
.ztree li.last-level{float:left;font-weight:normal}
</style>
<script>
var $container = jQuery('#auth-container').height($(window).height() - parseInt($('#page-container').css('padding-top')) - $('#page-container').position().top - 200);
var nodes = <?= json_encode($nodes) ?>, access = <?= json_encode($access) ?>, checkList = {};
for(var i in access){
	checkList[access[i]] = 1;
}
delete(access);
function parseData(data){
	var newData = [], tmp;
	for (var k in data) {
		if (!data.hasOwnProperty(k)) continue;
		tmp = {name:data[k]['title']};
		if (data[k]['path']) {
			tmp.path = data[k]['path'];
			tmp.checked = typeof checkList[tmp.path] !== 'undefined';
		} else if (data[k]['children']) {
			tmp.open = true;
			tmp.children = arguments.callee(data[k]['children']);
			for(var i = 0; i < tmp.children.length; i++){
				if(tmp.children[i].checked){
					tmp.checked = true;
					break;
				}
			}
		}
		newData.push(tmp);
	}
	return newData;
}
var setting = {
	view: {showLine: false, showIcon: false, dblClickExpand: false},
	check: {enable: true, nocheck: false, chkboxType: {"Y": "ps", "N": "ps"}},
	callback: {
		beforeClick: function (treeId, treeNode) {
			if (treeNode.isParent) {
				window.ztree.expandNode(treeNode);
			} else {
				window.ztree.checkNode(treeNode, null, true, true);
			}
			return false;
		},
		onNodeCreated:function(event, treeId, treeNode) {
			if (!treeNode.isParent) $("#" + treeNode.tId).addClass('last-level');
		}
	}
};
require(['ztree'],function(){
	window.ztree = jQuery.fn.zTree.init($container, setting, parseData(nodes));
	$('#access-spinner').remove();
	$('#btns').show();
	$('#auth-form').submit(function(e){
		e.preventDefault();
		var checkList = window.ztree.getCheckedNodes(true),nodes=[];
		for(var i = 0; i < checkList.length; i++){
			checkList[i].path && nodes.push(checkList[i].path);
		}
		$.http.post(this.action, {id: <?= \Yii::$app->request->get('id') ?>, nodes: nodes}, {
			before:function(){
				this.loadingIndex = $.msg.loading('保存中');
			},
			after:function(){
				$.msg.closeLoading(this.loadingIndex);
			},
			success:function(d){
				if (d.status === 1) {
					$.msg.success(d.info, 1000, function(){
						$.page.back();
					});
				} else {
					$.msg.error(d.info);
				}
			}
		});
	});
});
</script>
<?php $this->endBlock() ?>
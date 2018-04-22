 <?php $this->beginBlock('title') ?>
菜单管理
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('menu/refresh')) { ?>
<button type="button" title="更新左侧菜单缓存" class="btn btn-xs btn-info" data-load="<?=\yii\helpers\Url::toRoute('refresh')?>"><i class="glyphicon glyphicon-refresh"></i>&nbsp;刷新菜单缓存</button>
<?php } ?>
<?php if (checkAuth('menu/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-modal="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;添加菜单</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function getMenuName(name,vo) {
	return vo.spl+name;
}
function getIcon(icon) {
	return '<i class="'+icon+'"></i>';
}
function getAddMenuBtn(key,row,name,path){
	return getOperationButton(name, {'data-modal': url.toRoute(path,{pid:row[key]})});
}
</script>
<?= renderTable([
	'sort' => 'sort',
	'columns' => array(
		array('field' => 'icon', 'title' => '图标', 'js' => 'getIcon'),
		array('field' => 'name', 'title' => '菜单名', 'js' => 'getMenuName', 'align' => 'left'),
		array('field' => 'url', 'title' => '链接地址', 'align' => 'left'),
		array('field' => 'status', 'title' => '状态', 'js' => 'showStatus')
	),
	'operations' => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'getEditButton', 'path' => 'menu/edit'),
		array('key' => 'id', 'text' => '添加', 'js' => 'getAddMenuBtn', 'path' => 'menu/add'),
		array('key' => 'status', 'js' => 'getToggleButton', 'path' => 'menu/change-status'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'menu/del')
	),
	'list' => $list
]) ?>
<?php $this->endBlock() ?>
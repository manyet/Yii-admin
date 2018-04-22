<?php $this->beginBlock('title') ?>
角色管理
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('role/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-modal="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;添加角色</button>
<?php } ?>
<!--<button type="button" class="btn btn-xs btn-danger"><i class="fa fa-times"></i>&nbsp;删除</button>-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= renderTable([
	'columns' => array(
		array('field' => 'name', 'title' => '角色名'),
		array('field' => 'status', 'title' => '状态', 'js' => 'showStatus'),
		array('field' => 'create_time', 'title' => '创建时间', 'js' => 'showDate')
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'getEditButton', 'path' => 'role/edit'),
		array('key' => 'id', 'text' => '授权', 'js' => 'getHrefButton', 'path' => 'role/access'),
		array('key' => 'status', 'js' => 'getToggleButton', 'path' => 'role/change-status'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'role/del')
	),
	'list' => $list
]) ?>
<?php $this->endBlock() ?>

<?php
if (isset($pager) && $pager !== '') {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
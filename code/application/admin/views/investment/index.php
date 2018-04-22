<?php $this->beginBlock('title') ?>项目管理<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('investment/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-href="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i> 新增项目</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= renderTable([
	'columns' => array(
		array('field' => 'name', 'title' => '项目名称'),
		array('field' => 'start_date', 'title' => '启动时间'),
		array('field' => 'achievement', 'title' => '每达到以下金额发放利息', 'js' => 'moneyFormat'),
		array('field' => 'interest_rate', 'title' => '未分红利息比例'),
		array('field' => 'old_interest_rate', 'title' => '已分红利息比例'),
		array('field' => 'status', 'title' => '项目状态', 'js' => 'showStatus'),
		array('field' => 'create_time', 'title' => '添加时间', 'js' => 'showDate')
	),
	'operations' => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'getHrefButton', 'path' => 'investment/edit'),
		array('key' => 'status', 'js' => 'getToggleButton', 'path' => 'investment/change-status'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'investment/del')
	),
	'list' => $list
]) ?>
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
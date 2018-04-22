<?php $this->beginBlock('title') ?>
消息模板
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('template/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-modal="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;新增</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'title', 'title' => '模板标题'),
		array('field' => 'key', 'title' => '调用KEY'),
		array('field' => 'is_send_mobile', 'title' => '发送短信', 'js' => 'showStatus'),
		array('field' => 'is_send_message', 'title' => '发送消息', 'js' => 'showStatus')
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'showEditButton', 'path' => 'template/edit')
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
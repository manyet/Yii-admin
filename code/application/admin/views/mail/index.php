<?php $this->beginBlock('title') ?>
邮件模板
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'name', 'title' => '模板名称'),
		array('field' => 'title', 'title' => '邮件标题'),
		array('field' => 'eng_title', 'title' => '邮件标题（英文）'),
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'getHrefButton', 'path' => 'mail/edit')
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
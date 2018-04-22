<?php $this->beginBlock('title') ?>
业务反馈
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
$.createDatePicker('#start', '#end');
</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
	<div class="form-group">
		<div class="input-group input-group-sm">
			<input class="form-control" type="text" placeholder="开始时间"
				   name="start" id="start"
				   value="<?= \Yii::$app->request->get('start', '') ?>">
		</div>
		-
		<div class="input-group input-group-sm">
			<input class="form-control" type="text" placeholder="结束时间"
				   name="end" id="end"
				   value="<?= \Yii::$app->request->get('end', '') ?>">
		</div>
	</div>
	<div class="form-group">
		<button class="btn btn-sm btn-primary">搜索</button>
	</div>
</form>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'content', 'title' => '内容'),
		array('field' => 'create_time', 'title' => '时间', 'js' => 'showDate'),
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '查看', 'js' => 'getModalButton', 'path' => 'feedback/detail'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'feedback/del'),
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
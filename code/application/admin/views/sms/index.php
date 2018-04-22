<?php
$mobile = \Yii::$app->request->get('mobile');
$key = \Yii::$app->request->get('key');
?>
<?php $this->beginBlock('title') ?>
短信记录
<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
<script>function getSmsStatus(k){return k == 1 ? '<span class="text-success">成功</span>' : '<span class="text-danger">失败</span>';}</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
	<div class="form-group form-group-sm">
	  <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		<input class="form-control" type="text" placeholder="起始时间" name="start_date" id="start_date"
					   value="<?= \Yii::$app->request->get('start_date', '') ?>"/>
	  </div> - <div class="input-group">
		<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		<input class="form-control" type="text" placeholder="结束时间" name="end_date" id="end_date"
					   value="<?= \Yii::$app->request->get('end_date', '') ?>"/>
	  </div>
	</div>
	<div class="form-group form-group-sm">
		<input class="form-control" type="text" placeholder="手机号" name="mobile"
			   value="<?= \Yii::$app->request->get('mobile', '') ?>"/>
	</div>
	<button class="btn btn-sm btn-primary">搜索</button>
</form>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'recipient', 'title' => '手机号'),
		array('field' => 'status', 'title' => '发送状态', 'js' => 'getSmsStatus'),
		array('field' => 'create_time', 'title' => '发送时间', 'js' => 'showDate')
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '查看', 'js' => 'getModalButton', 'path' => 'sms/view'),
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

<?php $this->beginBlock('script') ?>
<script>$.createDatePicker('#start_date','#end_date');</script>
<?php $this->endBlock() ?>
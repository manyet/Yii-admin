<?php
$mobile = \Yii::$app->request->get('mobile');
$key = \Yii::$app->request->get('key');
?>
<?php $this->beginBlock('title') ?>
短信记录
<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
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
		<select class="form-control" name="key">
			<option value="">全部类型</option>
			<?php foreach ($this->params['typeList'] as $k => $value) { ?>
			<option value="<?= $k ?>"<?php if($key == $k) echo ' selected';?>><?= $value ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group form-group-sm">
		<input class="form-control" type="text" placeholder="手机号" name="mobile"
			   value="<?php if($mobile != '') echo $mobile;?>"/>
	</div>
	<button class="btn btn-sm btn-primary">搜索</button>
</form>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'mobile', 'title' => '手机号'),
		array('field' => 'key', 'title' => '类型'),
		array('field' => 'code', 'title' => '状态码'),
		array('field' => 'send_time', 'title' => '发送时间', 'js' => 'showDate')
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '查看', 'js' => 'getModalButton', 'path' => 'note/view'),
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
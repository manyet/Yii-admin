<?php $this->beginBlock('title') ?>
官方发布
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('notice/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-modal="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;新增</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
	<div class="form-group">
		<div class="input-group input-group-sm">
			<input class="form-control" type="text" placeholder="开始时间"
				   name="start_date" id="start_time"
				   value="<?= \Yii::$app->request->get('start_date', '') ?>">
		</div>
		-
		<div class="input-group input-group-sm">
			<input class="form-control" type="text" placeholder="结束时间"
				   name="end_date" id="end_time"
				   value="<?= \Yii::$app->request->get('end_date', '') ?>">
		</div>
	</div>
	<div class="form-group">
		<div class="input-group input-group-sm">
			<input class="form-control" type="text" placeholder="标题" name="keyword"
				   value="<?= \Yii::$app->request->get('keyword', '') ?>"/>
			<span class="input-group-btn"><button class="btn btn-primary">搜索</button></span>
		</div>
	</div>
</form>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'title', 'title' => '标题'),
                array('field' => 'type', 'title' => '发送对象'),
                array('field' => 'create_time', 'title' => '创建时间', 'js' => 'showDate')
	),
	'operations' => array(
		array('key' => 'id', 'text' => '查看', 'js' => 'getModalButton', 'path' => 'notice/view'),
                array('key' => 'id', 'text' => '编辑', 'js' => 'getEditButton', 'path' => 'notice/edit'),
                array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'notice/del')
	),
	'list' => $list
]) ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script'); ?>
<script>
var start = {
		elem: '#start_time',
		format: 'YYYY-MM-DD hh:mm:ss',
		min: '2016-01-01 00:00:00', //设定最小日期为当前日期
		max: laydate.now(), //最大日期
		istime: true,
		istoday: false,
		choose: function (datas) {
			end.min = datas; //开始日选好后，重置结束日的最小日期
			end.start = datas //将结束日的初始值设定为开始日
		}
	},
	end = {
		elem: '#end_time',
		format: 'YYYY-MM-DD hh:mm:ss',
		min: '2016-01-01 00:00:00', //设定最小日期为当前日期
		max: laydate.now(), //最大日期
		istime: true,
		istoday: false,
		choose: function (datas) {
			start.max = datas; //结束日选好后，重置开始日的最大日期
		}
	};
laydate(start);
laydate(end);
</script>
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
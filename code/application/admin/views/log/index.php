<?php $this->beginBlock('title') ?>系统日志<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('log/del')) { ?>
<button type="button" title="批量删除系统日志" class="btn btn-xs btn-warning" data-del="<?=\yii\helpers\Url::toRoute('del')?>"><i class="fa fa-trash-o"></i> 批量删除日志</button>
<?php } ?>
<?php if (checkAuth('log/del-all')) { ?>
<button type="button" title="清空所有系统日志" class="btn btn-xs btn-danger" data-clear="<?=\yii\helpers\Url::toRoute('del-all')?>"><i class="fa fa-trash-o"></i> 清空所有日志</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function getUsername(k, row){
	return k ? '<div style="white-space:nowrap">' + row.realname + '</div><span class="text-info">' + k + '</span>' : '未记录';
}
function getOperationContent(k, row){
	return k + ' - ' + row.content;
}
</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
	<div class="form-group form-group-sm">
	  <div class="input-group">
		<input class="form-control" type="text" placeholder="起始时间" name="start_date" id="start_date"
					   value="<?= \Yii::$app->request->get('start_date', '') ?>"/>
	  </div> - <div class="input-group">
		<input class="form-control" type="text" placeholder="结束时间" name="end_date" id="end_date"
					   value="<?= \Yii::$app->request->get('end_date', '') ?>"/>
	  </div>
	</div>
	<div class="form-group">
		<div class="input-group input-group-sm">
			<input type="text" style="min-width: 200px" name="kw" value="<?= \Yii::$app->request->get('kw', '') ?>" placeholder="操作人/IP地址/ISP信息/操作内容" class="form-control"> 
			<span class="input-group-btn">
			  <button class="btn btn-primary">搜索</button>
			</span>
		</div>
	</div>
</form>
<?= renderTable([
	'checkbox' => 'id',
	'columns' => array(
		array('field' => 'username', 'title' => '操作人', 'js' => 'getUsername', 'align' => 'left'),
		array('field' => 'title', 'title' => '操作内容', 'js' => 'getOperationContent', 'align' => 'left'),
		array('field' => 'ip', 'title' => 'IP地址', 'align' => 'left'),
		array('field' => 'isp', 'title' => 'ISP信息', 'align' => 'left'),
		array('field' => 'user_agent', 'title' => '客户端信息', 'align' => 'left'),
		array('field' => 'create_time', 'title' => '操作时间', 'js' => 'showDate')
	),
	'operations' => array(
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'log/del')
	),
	'list' => $list
]) ?>
<script>
$.createDatePicker('#start_date','#end_date');
$('[data-clear]').on('click', function() {
	var $this = $(this);
	$.msg.confirm('确定要清空所有日志吗？', function() {
		$.http.post($this.data('clear'));
	});
});
</script>
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
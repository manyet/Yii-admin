<?php 
$export_url = $cur_url . (strpos($cur_url = \yii\helpers\Url::current(), '?') ? '&' : '?') . 'export';
?>
<?php $this->beginBlock('title') ?>泥码订单<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('mudcode-order/index')) { ?>
<a class="btn btn-xs btn-primary" href="<?=$export_url;?>"target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;导出Excel</a>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function showIntegral(key) {
	return '娱乐分 ' + moneyFormat(key);
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
			<input type="text" style="min-width: 230px" name="kw" value="<?= \Yii::$app->request->get('kw', '') ?>" placeholder="订单编号/玩家姓名/玩家账号/赌场名称" class="form-control"> 
			<span class="input-group-btn">
			  <button class="btn btn-primary">搜索</button>
			</span>
		</div>
	</div>
</form>
    
<?=
renderTable([
    'columns' => array(
        array('field' => 'number', 'title' => '订单编号', 'align' => 'left'),
        array('field' => 'realname', 'title' => '玩家姓名', 'align' => 'left'),
        array('field' => 'uname', 'title' => '玩家账号', 'align' => 'left'),
        array('field' => 'amount', 'title' => '钱包消耗', 'align' => 'left', 'js' => 'showIntegral'),
        array('field' => 'count', 'title' => '兑换泥码', 'align' => 'left'),
        array('field' => 'casino_name', 'title' => '兑换赌场', 'align' => 'left'),
        array('field' => 'code', 'title' => '核销码', 'align' => 'left'),
        array('field' => 'create_time', 'title' => '兑换时间', 'js' => 'showDate')
    ),
    'list' => $list
])
?>

<script>
$.createDatePicker('#start_date','#end_date');
</script>    
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
    $this->beginBlock('footer');
    echo $pager;
    $this->endBlock();
}
?>
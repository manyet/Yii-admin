<?php
$export_url = $cur_url . (strpos($cur_url = \yii\helpers\Url::current(), '?') ? '&' : '?') . 'export';
?>
<?php $this->beginBlock('title') ?>公司分订单<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('transfer-order/index')) { ?>
    <a class="btn btn-xs btn-primary" href="<?=$export_url;?>"target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;导出Excel</a>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function getDescriptionBtn(key, row, text, path){
    if (row.state==0) {
        return '';
    }
    return getModalButton(key, row, text, path);
}
function getDescriptionBtns(key, row, text, path){
    if (row.state==1||row.state==2) {
        return '';
    }
    return getModalButton(key, row, text, path);
}
var identitys = <?= json_encode(getUserIdentity()) ?>;
function getidentity(identity){
	return identitys[identity];
}
function getType(modify_type){
    if (modify_type==1) {
        return '已实际收款';
    }if(modify_type==2) {
        return '无收益调整';
    }
}
function getvalue(type,row){
    if (type==1) {
        return '+'+row.value;
    }if(type==2) {
        return '-'+row.value;
    }
}

</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
    <div class="form-group">
		<div class="input-group input-group-sm">
			<select name="status" class="form-control">
				<option value="">全部状态</option>
				<?php
				$arr_status = [
					'1' => '已实际收款',
					'2' => '无收益调整',
				];

				foreach ($arr_status as $key => $value) {
					$status = Yii::$app->request->get('status', '');
					?>
					<option value="<?= $key ?>"<?php if ($status != '' && $key == $status) { echo ' selected'; } ?>><?= $value ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
    <div class="form-group">
		<div class="input-group input-group-sm">
			<select name="type" class="form-control">
				<option value="">全部身份</option>
				<?php
				$arr_status = getUserIdentity();

				foreach ($arr_status as $key => $value) {
					$type = Yii::$app->request->get('type', '');
					?>
					<option value="<?= $key ?>"<?php if ($type != '' && $key == $type) { echo ' selected'; } ?>><?= $value ?></option>
				<?php } ?>
			</select>
		</div>
    </div>
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="text" style="min-width: 180px" name="kw" value="<?= \Yii::$app->request->get('kw', '') ?>" placeholder="订单编号/玩家姓名/玩家账号" class="form-control">
            <span class="input-group-btn">
          <button class="btn btn-primary">搜索</button>
        </span>
        </div>
    </div>
</form>
<?= renderTable([
    'columns' => array(
        array('field' => 'order_num', 'title' => '订单编号', 'align' => 'left'),
        array('field' => 'realname', 'title' => '玩家姓名', 'align' => 'left'),
        array('field' => 'uname', 'title' => '玩家账号', 'align' => 'left'),
        array('field' => 'identity', 'title' => '身份', 'js' => 'getidentity', 'align' => 'left'),
        array('field' => 'balance_before', 'title' => '调整前余额', 'align' => 'left'),
        array('field' => 'type','title' => '调整分值', 'js' => 'getvalue', 'align' => 'left'),
        array('field' => 'balance_after', 'title' => '调整后余额', 'align' => 'left'),
        array('field' => 'create_time', 'title' => '申请时间', 'js' => 'showDate', 'align' => 'left'),
        array('field' => 'modify_type', 'title' => '调整类型', 'js' => 'getType', 'align' => 'left'),
    ),
    'list' => $list
])
?>
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
    $this->beginBlock('footer');
    echo $pager;
    $this->endBlock();
}
?>
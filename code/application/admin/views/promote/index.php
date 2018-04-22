<?php $this->beginBlock('title') ?>直推关系<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
<script>
var identitys = <?= json_encode(getUserIdentity()) ?>;
function showUserIdentity(key) {
	return identitys[key];
}
</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
	<div class="form-group">
		<input class="form-control input-sm" type="text" placeholder="用户名/真实姓名" name="key"
		   value="<?= \Yii::$app->request->get('key', '') ?>"/>
	</div>
	<div class="form-group">
		<input class="form-control input-sm" type="text" placeholder="推荐人用户名/真实姓名" name="promoter"
		   value="<?= \Yii::$app->request->get('promoter', '') ?>"/>
	</div>
	<button class="btn btn-primary btn-sm">搜索</button>
</form>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'uname', 'title' => '账号'),
		array('field' => 'realname', 'title' => '真实姓名'),
		array('field' => 'identity', 'title' => '身份', 'js' => 'showUserIdentity'),
		array('field' => 'promoter_uname', 'title' => '推荐人账号'),
		array('field' => 'promoter_realname', 'title' => '推荐人姓名'),
		array('field' => 'create_time', 'title' => '绑定时间', 'js' => 'showDate')
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
<?php $this->beginBlock('title') ?>用户列表<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
<script>
var identitys = <?= json_encode(getUserIdentity()) ?>;
function showUserIdentity(key) {
	return identitys[key];
}
function getCardButton(key,row,text,path) {
	if (!row['card_number']) {
		return getOperationButton(text,{
			'data-prompt': url.toRoute(path, {id: row[key]}),
			'data-title': '绑定 ' + row.uname +  ' 的会员卡',
		});
	}
	return '';
}
</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
	<div class="form-group">
		<div class="input-group input-group-sm">
			<select name="identity" class="form-control">
				<option value="">全部身份</option>
				<?php
				$identity = Yii::$app->request->get('identity');
				foreach (getUserIdentity() as $key => $value) {
				?>
				<option value="<?= $key ?>"<?php if ($identity == $key) echo ' selected'; ?>><?= $value ?></option>
				<?php } ?>
			</select>
		</div>
    </div>
	<div class="form-group">
		<div class="input-group input-group-sm">
			<input class="form-control" style="min-width: 180px;" type="text" placeholder="玩家账号/真实姓名/会员卡号" name="key"
			   value="<?= \Yii::$app->request->get('key', '') ?>"/>
			<span class="input-group-btn">
			  <button class="btn btn-primary">搜索</button>
			</span>
		</div>
	</div>
</form>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'uname', 'title' => '玩家账号'),
		array('field' => 'realname', 'title' => '真实姓名'),
		array('field' => 'card_number', 'title' => '会员卡号'),
		array('field' => 'identity', 'title' => '身份', 'js' => 'showUserIdentity'),
//		array('field' => 'status', 'title' => '状态', 'js' => 'showStatus'),
		array('field' => 'create_time', 'title' => '注册时间', 'js' => 'showDate')
	),
	'operations' => array(
		array('key' => 'id', 'text' => '详细资料', 'js' => 'getHrefButton', 'path' => 'member/detail'),
//		array('key' => 'status', 'js' => 'getToggleButton', 'path' => 'member/change-status'),
		array('key' => 'id', 'text' => '绑定会员卡', 'js' => 'getCardButton', 'path' => 'member/bind-card')
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
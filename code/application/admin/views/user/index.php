<?php $this->beginBlock('title') ?>
系统用户
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('user/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-modal="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;添加用户</button>
<?php } ?>
<!--<button type="button" class="btn btn-xs btn-danger"><i class="fa fa-times"></i>&nbsp;删除</button>-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id.'/'.$this->context->action->id) ?>" data-search>
	<div class="form-group">
		<div class="input-group input-group-sm">
			<input class="form-control" type="text" placeholder="用户名/真实姓名" name="key"
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
		array('field' => 'username', 'title' => '账号'),
		array('field' => 'realname', 'title' => '真实姓名'),
		array('field' => 'role', 'title' => '角色'),
		array('field' => 'status', 'title' => '状态', 'js' => 'showStatus'),
		array('field' => 'create_time', 'title' => '创建时间', 'js' => 'showDate')
	),
	'operations' => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'getEditButton', 'path' => 'user/edit'),
		array('key' => 'id', 'text' => '修改密码', 'js' => 'getModalButton', 'path' => 'user/update-pwd'),
		array('key' => 'status', 'js' => 'getToggleButton', 'path' => 'user/change-status'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'user/del')
	),
	'list' => $list
]) ?>
<?php $this->endBlock() ?>

<?php
if (isset($pager) && $pager !== '') {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
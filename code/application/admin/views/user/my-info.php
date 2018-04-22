<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>修改资料<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label">账号</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= empty($username) ? '' : $username; ?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">真实姓名</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= empty($realname) ? '' : $realname; ?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">头像</label>
	<div class="col-lg-10">
		<input type="hidden" name="avatar" value="<?=empty($avatar) ? '' : $avatar;?>" data-single-upload />
	</div>
</div>
<?php $this->endBlock() ?>
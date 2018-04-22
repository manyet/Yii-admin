<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>修改密码<?php $this->endBlock() ?>

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
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 密码</label>
	<div class="col-lg-10">
		<input type="password" name="pwd" id="pwd" required
			   placeholder="密码" class="form-control" autofocus="true" pattern="^[A-Za-z0-9]{6,20}$" title="密码由长度为6-20位的字母或数字组成" />
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 确认密码</label>
	<div class="col-lg-10">
		<input type="password" name="cpwd"
			   placeholder="确认密码" class="form-control" equalTo="#pwd" title="两次输入的密码不一致" />
	</div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer') ?>
<button type="button" class="btn btn-flat" data-dismiss="modal">关&nbsp;闭</button>
<button type="submit" class="btn btn-primary btn-flat" data-confirm-text="确定要修改密码？">保&nbsp;存</button>
<?php $this->endBlock() ?>
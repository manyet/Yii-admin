<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>短信信息<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label">KEY</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?=empty($key) ? '' : $key?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">手机号</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?=empty($mobile) ? '' : $mobile?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">发送时间</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= empty($send_time) ? '' : date('Y-m-d H:i:s', $send_time) ?></p>
	</div>
</div>

<?php if (!empty($expiry_time)) { ?>
<div class="form-group">
	<label class="col-lg-2 control-label">失效时间</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= date('Y-m-d H:i:s', $expiry_time) ?></p>
	</div>
</div>
<?php } ?>

<div class="form-group">
	<label class="col-lg-2 control-label">内容</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?=empty($content) ? '' : $content?></p>
	</div>
</div>

<div class="hr-line-dashed"></div>

<div class="form-group">
	<label class="col-lg-2 control-label">发送结果</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?=empty($code) ? '' : '[ ' . $code . ' ] '?> <?=empty($error_info) ? '发送成功' : $error_info?></p>
	</div>
</div>
<?php $this->endBlock() ?>
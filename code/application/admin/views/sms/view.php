<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>短信信息<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label">手机号</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= $recipient ?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">短信内容</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= $content ?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">发送时间</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= empty($create_time) ? '' : date('Y-m-d H:i:s', $create_time) ?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">发送结果</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= $status == 1 ? '<span>成功</span>' : '<span>失败</span>' ?></p>
	</div>
</div>

<div class="hr-line-dashed"></div>

<div class="form-group">
	<label class="col-lg-2 control-label">接口信息</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= $result ?></p>
	</div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer') ?>
<button type="button" class="btn btn-flat" data-dismiss="modal">关&nbsp;闭</button>
<?php $this->endBlock() ?>
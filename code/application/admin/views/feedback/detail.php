<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>业务反馈 - 详细<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label">内容</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= $content ?></p>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">时间</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= date('Y-m-d H:i:s') ?></p>
	</div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer') ?>
<button type="button" class="btn btn-white" data-dismiss="modal">关&nbsp;闭</button>
<?php $this->endBlock() ?>
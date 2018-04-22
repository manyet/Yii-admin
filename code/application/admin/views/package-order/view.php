<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>配套订单<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label">订单备注</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= $remark ?></p>
	</div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer') ?>
<button type="button" class="btn btn-flat" data-dismiss="modal">关&nbsp;闭</button>
<?php $this->endBlock() ?>
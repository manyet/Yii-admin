<?php $this->beginBlock("title") ?>
邮件配置
<?php $this->endBlock() ?>

<?php $this->beginBlock("content") ?>
<form class="form-horizontal" method="post" action="<?= yii\helpers\Url::toRoute('save') ?>" data-ajax data-validate>
<?= $this->render('//layouts/config', ['type' => '3']) ?>
<div class="form-group">
	<label class="col-sm-2 control-label"></label>
	<div class="col-sm-8">
		<button class="btn btn-primary btn-sm btn-flat">保存</button>
	</div>
</div>
</form>
<?php $this->endBlock() ?>
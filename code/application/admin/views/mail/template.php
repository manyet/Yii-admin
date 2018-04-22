<?php $this->beginBlock('title') ?>
邮件模板
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<button type="button" id="post" class="btn btn-xs btn-primary">更新发布</button>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<form id="form" method="POST" action="<?=\yii\helpers\Url::toRoute('template')?>" data-validate data-ajax="true" onSubmit="return false;">
<?php foreach ($list as $row) { ?>
<div class="clearfix">
	<div class="col-lg-6">
		<div class="callout callout-danger">
			<h4><?= $row['name'] ?></h4>
			<p><?= $row['description'] ?></p>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="callout" style="border: 1px solid #d2d6de">
			<h4>支持参数 <small>手动输入或点击参数复制，邮件标题、邮件均支持下列参数</small></h4>
			<p>
				<?php foreach(json_decode($row['params'], true) as $key => $value) { ?>
				<button type="button" data-clipboard-text="{{<?= $key ?>}}" class="btn btn-xs btn-success">{{<?= $key ?>}} <?= $value ?></button>
				<?php } ?>
			</p>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
			<label>中文邮件标题</label>
			<input type="text" name="<?= $row['key'] ?>[title]" class="form-control" value="<?= $row['title'] ?>"/>
		</div>
		<div class="form-group">
			<label>中文邮件内容</label>
			<textarea name="<?= $row['key'] ?>[content]" style="height: 300px;width: 100%"><?= $row['content'] ?></textarea>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
			<label>英文邮件标题</label>
			<input type="text" name="<?= $row['key'] ?>[eng_title]" class="form-control" value="<?= $row['eng_title'] ?>"/>
		</div>
		<div class="form-group">
			<label>英文邮件内容</label>
			<textarea name="<?= $row['key'] ?>[eng_content]" style="height: 300px;width: 100%"><?= $row['eng_content'] ?></textarea>
		</div>
	</div>
</div>
<?php } ?>
</form>
<script>
$('[data-clipboard-text],[data-clipboard-target]').createClipboard();
var $form = $('#form');
$('#post').click(function () {
	$form.submit();
});
$form.find('textarea').createEditor();
</script>
<?php $this->endBlock() ?>
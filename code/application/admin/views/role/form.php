<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>角色信息<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 角色名</label>
	<div class="col-lg-10">
		<input type="text" name="name" value="<?= empty($name) ? '' : $name; ?>" placeholder="角色名"
			title="请输入角色名称" class="form-control" autofocus="true" required=""/>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">状态</label>
	<div class="col-lg-10">
		<div class="radio radio-success radio-inline">
			<input required id="radio-status-1" type="radio" name="status" value="1"<?php if (empty($status) || isset($status) && intval($status) === 1){ ?> checked<?php } ?>>
			<label for="radio-status-1">启用</label>
		</div>
		<div class="radio radio-warning radio-inline">
			<input required id="radio-status-0" type="radio" name="status" value="0"<?php if (isset($status) && intval($status) === 0){ ?> checked<?php } ?>>
			<label for="radio-status-0">禁用</label>
		</div>
	</div>
</div>
<?php if (!empty($id)) { ?>
<div class="form-group">
	<label class="col-lg-2 control-label">创建时间</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= empty($create_time) ? '' : date('Y-m-d H:i:s', $create_time); ?></p>
	</div>
</div>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>
<?php $this->endBlock() ?>
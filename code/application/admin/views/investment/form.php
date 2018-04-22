<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>项目管理<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<button type="button" data-href="<?= $returnUrl ?>" class="btn btn-xs btn-default">返回上一页</button>
<button type="button" id="post" class="btn btn-xs btn-primary">确认保存</button>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content'); ?>
<form id="form" data-ajax data-validate class="form-horizontal" action="<?= yii\helpers\Url::current() ?>" method="post">

<div class="form-group">
	<div class="col-lg-4" style="width: 315px">
		<input type="hidden" name="img_path" value="<?= empty($img_path) ? '' : $img_path; ?>" data-single-upload data-width="300px" data-height="208px"/>
		<p class="help-block margin-bottom-none text-center">推荐尺寸 300 X 208</p>
	</div>
	<div class="col-lg-8">

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 分红利息发放</label>
	<div class="col-lg-10">
		<div class="input-group">
			<div class="input-group-addon">每次达到</div>
			<input class="form-control" min="0" required name="achievement" title="请检查分红利息发放金额" placeholder="此金额" value="<?= !isset($achievement) ? '' : $achievement ?>"/>
			<div class="input-group-addon">发放利息</div>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 未分红利息比例</label>
	<div class="col-lg-10">
		<div class="input-group">
			<input class="form-control" min="0" max="100" required name="interest_rate" title="请检查未分红利息比例格式" placeholder="0-100" value="<?= !isset($interest_rate) ? '' : $interest_rate ?>"/>
			<div class="input-group-addon">%</div>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 已分红利息比例</label>
	<div class="col-lg-10">
		<div class="input-group">
			<input class="form-control" min="0" max="100" required name="old_interest_rate" title="请检查已分红利息比例格式" placeholder="0-100" value="<?= !isset($old_interest_rate) ? '' : $old_interest_rate ?>"/>
			<div class="input-group-addon">%</div>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 项目启动日期</label>
	<div class="col-lg-10">
		<input type="text" id="start_date" name="start_date" value="<?= empty($start_date) ? '' : $start_date; ?>"
			   placeholder="请选择项目启动日期" class="form-control" required="" title="请选择项目启动日期" readonly/>
	</div>
</div>
<?php if (!empty($id)) { ?>
<div class="form-group">
	<label class="col-lg-2 control-label">项目添加时间</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= empty($create_time) ? '' : date('Y-m-d H:i:s', $create_time); ?></p>
	</div>
</div>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>

	</div>
</div>

<div class="form-group">
	<div class="col-lg-6">
		<label><b class="text-danger">*</b> 项目名称</label>
		<div>
			<input type="text" name="name" value="<?= empty($name) ? '' : $name; ?>"
				   placeholder="项目名称" class="form-control" required="" title="请输入项目名称"/>
		</div>
	</div>
	<div class="col-lg-6">
		<label><b class="text-danger">*</b> 项目名称（英文）</label>
		<div>
			<input type="text" name="name_en" value="<?= empty($name_en) ? '' : $name_en; ?>"
				   placeholder="项目名称（英文）" class="form-control" required="" title="请输入项目名称（英文）"/>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-lg-6">
		<label><b class="text-danger">*</b> 项目介绍</label>
		<div>
			<textarea name="description" placeholder="项目介绍" class="form-control" required="" title="请输入项目介绍" rows="6"><?= empty($description) ? '' : $description; ?></textarea>
		</div>
	</div>
	<div class="col-lg-6">
		<label><b class="text-danger">*</b> 项目介绍（英文）</label>
		<div>
			<textarea name="description_en" placeholder="项目介绍（英文）" class="form-control" required="" title="请输入项目介绍（英文）" rows="6"><?= empty($description_en) ? '' : $description_en; ?></textarea>
		</div>
	</div>
</div>
</form>
<script>
$('#post').click(function () { $('#form').submit(); });
$.createDatePicker('#start_date', '', {format: 'YYYY-MM-DD', istime: false});
</script>
<?php $this->endBlock() ?>
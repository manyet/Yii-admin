<section class="content">
<div class="nav-tabs-custom animated fadeInUp">
	<ul class="nav nav-tabs pull-right">
		<?php foreach ($groups as $key => $value) { ?>
		<li<?php if ($key == $type) { ?> class="active"<?php } ?>><a href="javascript:;" data-href="<?= \yii\helpers\Url::toRoute(['index', 'type' => $key]) ?>"><?= $value ?></a></li>
		<?php } ?>
		<?php if (checkAuth('config/refresh')) { ?>
		<li>
			<a class="text-muted" href="javascript:;" data-load="<?= \yii\helpers\Url::toRoute('refresh') ?>" title="刷新配置缓存">
				<i class="glyphicon glyphicon-refresh"></i>
			</a>
		</li>
		<?php } ?>
		<li class="pull-left header">
			<i class="fa fa-cogs"></i>
			<?= $this->context->controller_title ?>
			<small class="text-muted">前后台通用配置</small>
		</li>
	</ul>
	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<div class="panel-body">
			<form method="post" action="<?= \yii\helpers\Url::toRoute('save') ?>" class="form-horizontal" data-validate data-ajax>
				<?php foreach ($list as $row) { ?>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php if ($row['required'] == 1) { ?><b class="text-danger">*</b> <?php } ?><?= $row['title'] ?></label>
					<div class="col-sm-10">
						<?php if ($row['type'] == 0) { ?>
						<div class="row"><div class="col-md-3"><input type="number" class="form-control"<?php if ($row['pattern'] != '') { ?> pattern="<?= $row['pattern'] ?>"<?php } ?><?php if ($row['invalid_tip'] != '') { ?> title="<?= $row['invalid_tip'] ?>"<?php } ?><?php if ($row['required'] == 1) { ?> required<?php } ?> name="config[<?= $row['name'] ?>]" value="<?= $row['value'] ?>"/></div></div>
						<?php } else if ($row['type'] == 1) { ?>
						<input type="text" class="form-control"<?php if ($row['pattern'] != '') { ?> pattern="<?= $row['pattern'] ?>"<?php } ?><?php if ($row['invalid_tip'] != '') { ?> title="<?= $row['invalid_tip'] ?>"<?php } ?><?php if ($row['required'] == 1) { ?> required<?php } ?> name="config[<?= $row['name'] ?>]" value="<?= $row['value'] ?>"/>
						<?php } else if ($row['type'] == 2) { ?>
						<textarea class="form-control"<?php if ($row['pattern'] != '') { ?> pattern="<?= $row['pattern'] ?>"<?php } ?><?php if ($row['invalid_tip'] != '') { ?> title="<?= $row['invalid_tip'] ?>"<?php } ?><?php if ($row['required'] == 1) { ?> required<?php } ?> name="config[<?= $row['name'] ?>]"><?= $row['value'] ?></textarea>
						<?php
						} else if ($row['type'] == 3) {
							$extra = explode(strpos($row['extra'], ',') !== false ? ',' : '\n', $row['extra']);
							$checked = explode(',', $row['value']);
							foreach ($extra as $key => $one) {
								list($value, $text) = explode(':', $one);
						?>
						<div class="checkbox checkbox-primary checkbox-inline"><input type="checkbox"<?php if ($row['required'] == 1) { ?> required<?php } ?><?php if (in_array($value, $checked)) { ?> checked<?php } ?> name="config[<?= $row['name'] ?>][]" value="<?= $value ?>" id="checkbox-<?= $row['name'] ?>-<?= $key + 1 ?>"/><label for="checkbox-<?= $row['name'] ?>-<?= $key + 1 ?>"><?= $text ?></label></div>
						<?php
							}
						} else if ($row['type'] == 4) {
							$extra = explode(strpos($row['extra'], ',') !== false ? ',' : '\n', $row['extra']);
							foreach ($extra as $key => $one) {
								list($value, $text) = explode(':', $one);
						?>
						<div class="radio radio-primary radio-inline">
							<input type="radio"<?php if ($row['required'] == 1) { ?> required<?php } ?><?php if ($row['value'] == $value) { ?> checked<?php } ?> name="config[<?= $row['name'] ?>]" value="<?= $value ?>" id="radio-<?= $row['name'] ?>-<?= $key + 1 ?>"/>
							<label for="radio-<?= $row['name'] ?>-<?= $key + 1 ?>"><?= $text ?></label>
						</div>
						<?php
							}
						}
						?>
						<?php if (isset($row['remark']) && $row['remark'] != '') { ?>
						<span class="help-block margin-bottom-none"><?= $row['remark'] ?></span>
						<?php } ?>
					</div>
				</div>
				<div class="hr-line-dashed"></div>
				<?php } ?>
				<input type="hidden" name="type" value="<?= $type ?>" />
				<?php if (checkAuth('config/edit')) { ?>
				<div class="form-group" style="margin-bottom:0">
					<div class="col-sm-4 col-sm-offset-2">
						<button class="btn btn-primary btn-sm btn-flat" type="submit">保存</button>
						<button class="btn btn-sm btn-flat" type="button" onclick="$.page.back()">返回</button>
					</div>
				</div>
				<?php } ?>
			</form>
			</div>
		</div>
	</div>
</div>
</section>
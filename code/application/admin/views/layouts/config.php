<?php
$list = \admin\services\SystemConfigService::getConfigList($type, '`name`,`type`,title,value,`group`,extra,remark,required,pattern,invalid_tip');
foreach ($list as $row) {
?>
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
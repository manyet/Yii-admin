<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>用户信息<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 账号</label>
	<div class="col-lg-10">
		<?php if (empty($id)){?>
		<input type="text" name="username" placeholder="账号" class="form-control" autofocus="true"
			   pattern="^[A-Za-z0-9]{6,20}$" required="" title="账号由长度为6-20位的字母或数字组成"/>
		<?php } else { ?>
		<p class="form-control-static"><?= $username ?></p>
		<?php } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 真实姓名</label>
	<div class="col-lg-10">
		<input type="text" name="realname" value="<?= empty($realname) ? '' : $realname; ?>"
			   placeholder="真实姓名" class="form-control" required="" title="请输入真实姓名"/>
	</div>
</div>
<?php if (empty($id)){?>
<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 密码</label>
	<div class="col-lg-10">
		<input type="password" name="pwd" placeholder="密码" class="form-control" pattern="^[A-Za-z0-9]{6,20}$" required="" title="密码由长度为6-20位的字母或数字组成"/>
	</div>
</div>
<?php }?>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 角色</label>
	<div class="col-lg-10 row">
		<?php
		$selected_roles = empty($role_id) ? [] : explode(',', $role_id);
		foreach ($roles as $item) {
		?>
		<div class="col-sm-4">
			<div class="checkbox checkbox-info checkbox-inline">
				<input required type="checkbox" title="请选择角色" id="checkbox-role-<?= $item['id'] ?>" name="role_id[]" value="<?= $item['id'] ?>"<?php if (in_array($item['id'], $selected_roles)) { ?> checked<?php } ?>/>
				<label for="checkbox-role-<?= $item['id'] ?>"><?= $item['name'] ?></label>
			</div>
		</div>
		<?php } ?>
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
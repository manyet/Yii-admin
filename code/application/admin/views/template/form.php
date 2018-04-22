<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>模板信息<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 模板标题</label>
	<div class="col-lg-10">
		<input type="text" name="title" value="<?= empty($title) ? '' : $title; ?>" class="form-control">
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 模板描述</label>
	<div class="col-lg-10">
		<textarea name="description" placeholder="模板描述，应用场景" class="form-control" autofocus><?=empty($description) ? '' : $description?></textarea>
	</div>
</div>


<div class="form-group">
	<label class="col-lg-2 control-label">支持参数</label>
	<div class="col-lg-10">
        <?php if(!empty($params)){ ?>
		<div class="form-control-static">
			<table>
				<tbody>
			<?php
			$params = json_decode($params, true);
			foreach ($params as $key => $name) {
			?>
			<tr>
				<td style="padding-right: 8px">{{<?= $key ?>}}</td>
				<td><?= $name ?></td>
			</tr>
			<?php } ?>
				</tbody>
			</table>
		</div>
		<?php } else { ?>
		<textarea name="params" placeholder="支持参数" class="form-control" required></textarea>
		<?php } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">短信消息</label>
	<div class="col-lg-10">
		<div class="checkbox checkbox-primary">
		  <input id="is_send_mobile" data-send-input type="checkbox" name="is_send_mobile"<?php if(!isset($is_send_mobile) || $is_send_mobile==1) { ?>checked<?php }?>/>
		  <label for="is_send_mobile">开启</label>
		</div>
		<textarea rows="3" id="is_send_mobile-input" name="mobile_content" placeholder="短信内容" class="form-control" autofocus><?=empty($mobile_content) ? '' : $mobile_content?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">消息中心</label>
	<div class="col-lg-10">
		<div class="checkbox checkbox-primary">
		  <input id="is_send_message" data-send-input type="checkbox" name="is_send_message"<?php if(!isset($is_send_message) || $is_send_message==1) { ?>checked<?php }?>/>
		  <label for="is_send_message">开启</label>
		</div>
		<textarea rows="3" id="is_send_message-input" name="message_content" placeholder="消息内容" class="form-control"><?=empty($message_content) ? '' : $message_content?></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">业务反馈</label>
	<div class="col-lg-10">
		<div class="checkbox checkbox-primary">
		  <input id="is_send_system" data-send-input type="checkbox" name="is_send_system"<?php if(!isset($is_send_system) || $is_send_system==1) { ?>checked<?php }?>/>
		  <label for="is_send_system">开启</label>
		</div>
		<textarea rows="3" id="is_send_system-input" name="system_content" placeholder="反馈内容" class="form-control"><?=empty($system_content) ? '' : $system_content?></textarea>
	</div>
</div>

<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>
<script>
$('[data-send-input]').change(function(){
	$('#' + this.id + '-input')[this.checked ? 'show' : 'hide']();
}).each(function(){
	$('#' + this.id + '-input')[this.checked ? 'show' : 'hide']();
});
</script>
<?php $this->endBlock() ?>
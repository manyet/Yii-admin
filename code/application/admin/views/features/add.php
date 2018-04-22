<?php $this->beginBlock('title') ?>
功能介绍
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<button class="btn btn-xs btn-default" data-thumb="<?= get_img_url('advertising-d.jpeg') ?>" data-max-width="1000">位置图览</button>
<button type="button" id="yu" class="btn btn-xs btn-primary">预览</button>
<button type="button" id="post" class="btn btn-xs btn-primary">更新发布</button>
<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
<div class="callout callout-info">
	<h4>广告位描述</h4>
	<p>功能介绍位于莫斯PC平台首页顶部，可点击右侧‘位置图览’进行位置查看。建议该介绍类目不超过6位，建议图片尺寸为950 x 470（建议每张图比例一样），支持格式JPG、PNG，可预览后再做发布处理。</p>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<style>.form-horizontal .checkbox{padding-top: 1px}</style>
<?php
$lenght = 6;
$vars = get_defined_vars();
unset($vars['_params_']);
?>
<form id="form" method="POST" action="<?=\yii\helpers\Url::toRoute('addlist')?>" data-validate data-ajax="true" onSubmit="return false;">
	<?php for ($i = 1; $i <= $lenght; $i++) { ?>
    <div class="form-group" style="background: #fafafb;border: 1px solid #e7eaec;padding: 15px">
		<div style="padding-bottom: 15px">
			<div class="checkbox checkbox-info checkbox-inline">
				<input type="checkbox" id="checkbox-features-<?= $i ?>" name="features_open<?= $i ?>" value="1" <?php if (!empty($vars['features_open' . $i]) && $vars['features_open' . $i] == 1) { ?> checked<?php } ?>/>
				<label for="checkbox-features-<?= $i ?>"></label>
			</div>
			<input data-width="100px" type="hidden" name="features_Picture<?= $i ?>" value="<?=empty($vars['features_Picture' . $i]) ? '' : $vars['features_Picture' . $i];?>" data-single-upload data-height="50px" data-width="50px" />
			<div class="pull-right text-primary" style="font-size: 30px"><?= $i ?></div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>标题</label>
					<input type="text" name="title<?= $i ?>" value="<?=empty($vars['title' . $i]) ? '' : $vars['title' . $i];?>" class="form-control"/>
					<!--<label>摘要</label>
					<input type="text" name="summary<?= $i ?>" value="<?=empty($vars['summary' . $i]) ? '' : $vars['summary' . $i];?>" class="form-control"/>-->
					<label>详细内容</label>
					<textarea  type="text" name="details<?= $i ?>" rows="3" class="form-control"><?=empty($vars['details' . $i]) ? '' : $vars['details' . $i];?></textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>标题(英文)</label>
					<input type="text" name="e_title<?= $i ?>" value="<?=empty($vars['e_title' . $i]) ? '' : $vars['e_title' . $i];?>" class="form-control"/>
					<!--<label>摘要(英文)</label>
					<input type="text" name="e_summary<?= $i ?>" value="<?=empty($vars['e_summary' . $i]) ? '' : $vars['e_summary' . $i];?>" class="form-control"/>-->
					<label>详细内容(英文)</label>
					<textarea  type="text" name="e_details<?= $i ?>" rows="3" class="form-control"><?=empty($vars['e_details' . $i]) ? '' : $vars['e_details' . $i];?></textarea>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<input type="hidden" name="id" value="<?=empty($id) ? '' : $id;?>"/>
</form>
<script>
$('#post').click(function () {
	$('#form').submit();
});
$("button#yu").on('click', function () {
	var arr = [];
	for (var i = 1; i <= <?= $lenght ?>; i++) {
		console.log($("[name='features_open" + i + "']")[0])
		if ($("[name='features_open" + i + "']")[0].checked) {
			var name = 'features_Picture' + i;
			arr.push(name + '=' + $("input[name='" + name + "']").val());
		}
	}
    $.msg.iframe('预览','<?= Yii::$app->params['frontUrl'] . '/main/features.html' ?>'+'?'+arr.join('&'), '1220px','530px');
});
</script>
<?php $this->endBlock() ?>
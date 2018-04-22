<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>文章管理<?php $this->endBlock() ?>

<?php $this->beginBlock('content'); ?>
<div style="">
<div class="alert alert-info">
	<!--<h4><i class="icon fa fa-ban"></i> Alert!</h4>-->
	文章标题支持自动替换用户昵称，如需使用用户昵称，请使用 {{nickname}} 替代
  </div>
<form role="form" action="<?= \yii\helpers\Url::toRoute('save') ?>" method="post" data-validate data-ajax>
<div class="form-group">
	<label>文章标题</label>
	<input required name="title" type="text" class="form-control" placeholder="请填写文章标题" title="请填写文章标题" value="<?= isset($title) ? $title : '' ?>">
</div>
<div class="form-group">
	<label>作者</label>
	<input required name="author" type="text" class="form-control" placeholder="请填写文章作者" title="请填写文章作者" value="<?= isset($author) ? $author : '' ?>">
</div>
<div class="form-group">
	<label>封面</label>
	<br/>
	<input name="local_url" required type="hidden" class="form-control" data-width="auto" data-height="100px" data-single-upload value="<?= isset($local_url) ? $local_url : '' ?>">
	<br/>
	<div class="checkbox checkbox-info checkbox-inline">
		<input type="checkbox" id="checkbox-show-cover" name="show_cover_pic" value="1"<?php if (isset($show_cover_pic) && $show_cover_pic == 1) { ?> checked<?php } ?>/>
		<label for="checkbox-show-cover">封面显示在正文中</label>
	</div>
	<p class="help-block">支持JPG、PNG格式，较好的效果为大图360*200，小图200*200</p>
</div>
<div class="form-group">
	<label>文章摘要</label>
	<textarea name="digest" required class="form-control" rows="3" placeholder="请填写文章摘要" title="请填写文章摘要"><?= isset($digest) ? $digest : '' ?></textarea>
</div>
<div class="form-group">
	<label>文章内容</label>
	<textarea style="height: 300px;" id="content" name="content" required placeholder="请填写文章内容" title="请填写文章内容"><?= isset($content) ? $content : '' ?></textarea>
</div>
<div class="form-group">
	<label>原文链接（选填）</label>
	<input name="content_source_url" type="text" class="form-control" placeholder="请填写原文链接" title="请填写原文链接" value="<?= isset($content_source_url) ? $content_source_url : '' ?>">
</div>

<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>

<button class="btn btn-primary">保存</button>
<button class="btn" type="button" onclick="$.page.back()">返回</button>
</form>
</div>
<script>
$('#content').createEditor();
</script>
<?php $this->endBlock() ?>
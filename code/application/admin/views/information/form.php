<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>资讯管理<?php $this->endBlock() ?>

<?php $this->beginBlock('content'); ?>
<form role="form" action="<?= \yii\helpers\Url::toRoute('edit') ?>" method="post" data-validate data-ajax>
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

<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>

<button class="btn btn-primary">保存</button>
<button class="btn" type="button" onclick="$.page.back()">返回</button>
</form>
<script>
$('#content').createEditor();
</script>
<?php $this->endBlock() ?>
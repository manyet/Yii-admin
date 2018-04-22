<?php use yii\helpers\Url; ?>
<?php $this->beginBlock('title') ?>
关注回复
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<style>
.phone-container{margin: 20px; position: relative;}
</style>
<div style="float:left">
	<div class="phone-container">
			<img onclick="history.back();" src="<?= get_img_url() ?>/wechat-head.png" style="width:100%"/>
		<div class="phone-screen">
			<iframe id="phone-frame" frameborder="0" marginheight="0" marginwidth="0"></iframe>
		</div>
	</div>
</div>
<div style="float:left;margin-top: 25px;min-width: 300px;max-width:500px;">
<form role="form" action="<?= Url::toRoute('subscribe-submit') ?>" method="post" data-ajax data-validate>
	<div class="form-group">
		<label>自动回复</label>
		<div>
			<div class="radio radio-success radio-inline">
				<input required id="radio-status-1" type="radio" name="status" value="1"<?php if (!isset($status) || intval($status) === 1) { ?> checked<?php } ?> />
				<label for="radio-status-1">开启</label>
			</div>
			<div class="radio radio-warning radio-inline">
				<input required id="radio-status-2" type="radio" name="status" value="0"<?php if (isset($status) && intval($status) === 0) { ?> checked<?php } ?> />
				<label for="radio-status-2">关闭</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label>回复类型</label>
		<div>
			<?php foreach (common\services\WechatService::getReplyType() as $key => $name) { ?>
			<div class="radio radio-primary radio-inline">
				<input required id="radio-type-<?= $key ?>" type="radio" name="type" value="<?= $key ?>" />
				<label for="radio-type-<?= $key ?>"><?= $name ?></label>
			</div>
			<?php } ?>
		</div>
	</div>
	<div data-type="text" class="hidden reply-type">
		<div class="form-group">
			<label>回复文本</label>
			<textarea class="form-control" rows="3" placeholder="请输入要回复的文本内容" required name="content"><?= empty($content) ? '' : $content ?></textarea>
			<p class="help-block">内容支持自动替换用户昵称，如需使用用户昵称，请使用 {{nickname}} 替代</p>
		</div>
	</div>
	<div data-type="news" class="hidden reply-type">
		<div class="form-group">
			<label>回复图文</label>
			<a data-iframe="<?= Url::toRoute('wechat-articles/choose') ?>" href="javascript:;">选择图文</a>
			<input type="hidden" name="news_id" value="<?= empty($news_id) ? '' : $news_id ?>" />
		</div>
	</div>
	<?php if (!empty($id)) { ?>
	<input name="id" type="hidden" value="<?= $id ?>" />
	<?php } ?>
	<input name="keys" type="hidden" value="subscribe" />
	<button class="btn btn-primary" type="submit">保存</button>
	<button class="btn" type="button" onclick="$.page.back()">返回</button>
</form>
</div>
<script>
$iframe = $("#phone-frame");
var ReplyView = function(){};
ReplyView.prototype.textView = function(text) {
	$iframe.attr('src', '<?= Url::toRoute('wechat-view/text') ?>?content=' + text);
};
ReplyView.prototype.newsView = function(id) {
	$iframe.attr('src', '<?= Url::toRoute('wechat-view/news') ?>?id=' + id);
};
var view = new ReplyView(), $replys = $('.reply-type');
$('[name=type]').change(function(){
	$replys.addClass('hidden');
	var args = [];
	$('[data-type=' + this.value + ']').removeClass('hidden').find(':input').each(function(){
		args.push(this.value);
	});
	view[this.value + 'View'].apply(null, args);
}).each(function(){
	if (this.value == '<?= empty($type) ? 'text' : $type ?>') {
		this.click();
		return false;
	}
});
$replys.each(function(){
	var $this = $(this), type = $this.data('type');
	$this.find(':input').change(function(){
		$('[name=type][value=' + type + ']').change();
	});
});
var $newsId = $('[name=news_id]');
var callbackChooseArticles = function(id) {
	$newsId.val(id).change();
}
</script>
<?php $this->endBlock() ?>
<?php
use common\services\WechatArticleService;
if (empty($articles)) { ?>
<div class="text-center text-danger">该图文不存在或已删除</div>
<?php
} else {
?>
<div class="direct-chat-info clearfix">
  <span><?= date('H:i') ?></span>
</div>
<?php if (count($articles) === 1) { ?>
<div class="wechat-news-view wechat-single-view">
	<a href="<?= WechatArticleService::getDetailUrl($articles[0]) ?>">
		<p class="f-fwb wechat-news-single-top"><?= $articles[0]['title'] ?></p>
		<p class="wechat-news-single-p"><?= date('m月d日') ?></p>
		<div class="wechat-news-single-img"><img src="<?= $articles[0]['local_url'] ?>" onerror="this.src='<?= get_img_url('default.png') ?>'" /></div>
		<p class="wechat-news-single-p"><?= $articles[0]['digest'] ?></p>
		<span class="f-mt10 wechat-news-single-span">查看全文</span>
	</div>
</div>
<?php } else { ?>
<ul class="wechat-news-view">
	<?php
	foreach ($articles as $key => $one) {
		if ($key == 0) {
	?>
	<li>
		<a href="<?= WechatArticleService::getDetailUrl($one) ?>">
			<div class="wechat-news-single-img">
				<img src="<?= $one['local_url'] ?>" onerror="this.src='<?= get_img_url('default.png') ?>'" />
				<div class="wechat-news-li-title"><?= $one['title'] ?></div>
			</div>
		</a>
	</li>
	<?php } else { ?>
	<li class="wechat-news-li">
		<a href="<?= WechatArticleService::getDetailUrl($one) ?>">
			<div class="wechat-news-img">
				<img src="<?= $one['local_url'] ?>" onerror="this.src='<?= get_img_url('default.png') ?>'" />
			</div>
			<div class="wechat-news-text"><?= $one['title'] ?></div>
		</a>
	</li>
	<?php
		}
	}
	?>
</ul>
<?php } ?>
<script src="<?= get_plugin_url() ?>jQuery/jquery-2.2.3.min.js"></script>
<script>
function handleImage(width,rate,$obj) {
	var height = width / rate;
	$obj.height(height);
	var $img = $obj.find('img').on('load', function() {
		handleImage(width,rate,$obj);
	});
	var imgWidth = $img.width(), imgHeight = $img.height();
	if (imgWidth && imgHeight) {
		if (imgWidth / imgHeight > rate) {
			$img.height('100%');
			$img.css('margin-left', '-' + $img.width() / 2);
			$img.css('left', '50%');
		} else {
			$img.width('100%');
			$img.css('margin-top', '-' + $img.height() / 2);
			$img.css('top', '50%');
		}
	}
}
$('.wechat-news-single-img').each(function(){
	var rate = 18 / 10, $this = $(this);
	handleImage($this.width(), rate, $this);
});
$('.wechat-news-img').each(function(){
	var rate = 1, $this = $(this);
	handleImage($this.width(), rate, $this);
});
</script>
<?php } ?>
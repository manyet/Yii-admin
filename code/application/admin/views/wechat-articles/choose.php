<?php 
use common\models\WechatArticle;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>选择图文</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>bootstrap/css/bootstrap.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?= get_platform_url() ?>js/html5shiv.min.js"></script>
  <script src="<?= get_platform_url() ?>js/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="<?= get_css_url() ?>animate.css">
  <script src="<?= get_plugin_url() ?>jQuery/jquery-2.2.3.min.js"></script>
</head>
<body>
<?php if (empty($list)) { ?>
<div style="padding: 50px 0;text-align: center;">暂无多图文，请添加</div>
<?php } else { ?>
<div class="wechat-list-container">
<?php
foreach ($list as $row) {
?>
<ul class="wechat-list-view" data-id="<?= $row['id'] ?>">
	<li>点击选择该图文</li>
	<?php $articles = WechatArticle::find()->where("id IN ({$row['article_id']})")->orderBy(["field (`id`,{$row['article_id']})" => SORT_ASC])->asArray()->all();
	foreach ($articles as $one) {
	?>
	<li>
		<div class="wechat-list-img" style="background-image: url(<?= $one['local_url'] ?>)"></div>
		<div class="wechat-list-text"><?= $one['title'] ?></div>
	</li>
	<?php } ?>
</ul>
<?php } ?>
</div>
<link rel="stylesheet" href="<?= get_css_url() ?>wechat.css">
<style>
.wechat-list-view:hover,.wechat-list-view.active{box-shadow:1px 0px 10px #0099CC;border-color:#0099CC}
.wechat-list-view{margin: 10px; float: left; cursor: pointer}
.wechat-list-img{height: 137px;width: 248px}
</style>
<script src="<?= get_plugin_url() ?>masonry.min.js"></script>
<script>
$('.wechat-list-view').click(function(){
	parent.callbackChooseArticles($(this).data('id'));
	parent.$.msg.closeIframeByName(window.name);
}).find('img').error(function(){
	this.src='<?= get_img_url('default.png') ?>';
});
$('.wechat-list-container').masonry();
</script>
<?php } ?>
</body>
</html>
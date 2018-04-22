<?php
use common\models\WechatArticle;
$this->beginBlock('title')
?>
多图文管理
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('wechat-articles/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-href="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;添加多图文</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<?php if (empty($list)) { ?>
<div style="padding: 50px 0;text-align: center;">暂无多图文</div>
<?php } else { ?>
<div class="wechat-list-container">
<?php
$view_auth = checkAuth('wechat-articles/view');
$edit_auth = checkAuth('wechat-articles/edit');
$del_auth = checkAuth('wechat-articles/del');
foreach ($list as $row) {
?>
<ul class="wechat-list-view">
	<li>
		<?php if ($view_auth) { ?>
		<div class="col-xs-4">
			<a href="javascript:;" data-wechat-view="<?= \yii\helpers\Url::toRoute(['wechat-view/news', 'id' => $row['id']]) ?>" title="预览"><i class="fa fa-eye"></i> 预览</a>
		</div>
		<?php } ?>
		<?php if ($edit_auth) { ?>
		<div class="col-xs-4">
			<a href="javascript:;" data-href="<?= \yii\helpers\Url::toRoute(['edit', 'id' => $row['id']]) ?>" title="编辑"><i class="fa fa-edit"></i> 编辑</a>
		</div>
		<?php } ?>
		<?php if ($del_auth) { ?>
		<div class="col-xs-4">
			<a href="javascript:;" data-del="<?= \yii\helpers\Url::toRoute('del') ?>" data-id="<?= $row['id'] ?>" title="删除"><i class="fa fa-trash-o"></i> 删除</a>
		</div>
		<?php } ?>
	</li>
	<?php $articles = WechatArticle::find()->where("id IN ({$row['article_id']})")->orderBy(["field (`id`,{$row['article_id']})" => SORT_ASC])->asArray()->all();
	foreach ($articles as $one) {
	?>
	<li>
		<div class="wechat-list-img" style="background-image:url(<?= $one['local_url'] ?>)"></div>
		<div class="wechat-list-text"><?= $one['title'] ?></div>
	</li>
	<?php } ?>
</ul>
<?php } ?>
</div>
<link rel="stylesheet" href="<?= get_css_url() ?>wechat.css">
<style>
.wechat-list-view:hover,.wechat-list-view.active{box-shadow:1px 0px 10px #0099CC;border-color:#0099CC}
.wechat-list-view{margin: 10px; float: left;}
.wechat-list-img{height: 137px;width: 248px}
</style>
<script>
$('.wechat-list-view img').error(function(){this.src='<?= get_img_url('default.png') ?>';});
require(["masonry"], function(Masonry) {
	setTimeout(function(){
		new Masonry('.wechat-list-container');
	}, 200);
});
</script>
<?php } ?>
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
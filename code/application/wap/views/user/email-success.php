<?php
/* @var $this \yii\web\View */
$this->title = Yii::t('app', 'user_bind_mailbox');
?>

<?php $this->beginBlock('header') ?>

<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<!--内容开始-->
<div class="limit-size bg-bd0a2e limit-height">

    <div class="bordtot-890625 logo_div">
		<div class="clearfix f-pl15 f-pr15 ">
			<span><img src="<?= Yii::getAlias('@img') ?>/logo.png" class="f-w25"/></span>
		</div>

		<div class="f-mt30 f-pl15 f-pr15">
			<div class="fc-fff f-fs18 f-tc f-mt10 f-mb10"><?= Yii::t('app', 'user_bind_mailbox_success') ?></div>
		</div>

		<div class="f-pl15 f-pr15 f-mt15 ">
			<a href="<?= \yii\helpers\Url::toRoute('user/index') ?>" class=""><button class="btn f-w100 f-fs16 f-pt10 f-pb10 fc-fff f-fwb f-br5 btn_yellowD"><?= Yii::t('app', 'click_to', ['text' => Yii::t('app', 'login')]) ?></button></a>
		</div>
    </div>
</div>
<!--内容结束-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>
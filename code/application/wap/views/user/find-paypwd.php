<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_find_pay_pwd');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('update-pay-pwd') ?>" class="back"></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<!--内容开始-->
<div class="limit-size bg-bd0a2e limit-height">

    <div class="bordtot-890625 logo_div">
		<form name="find_paypwd" data-ajax data-validate action="<?= \yii\helpers\Url::toRoute('find-pay-pwd-code') ?>" onsubmit="return false" method="post">
			<div class="clearfix f-pl15 f-pr15 ">
				<span><img src="<?= Yii::getAlias('@img') ?>/logo.png" class="f-w25"/></span>
				<span class="f-fs22 fc-f5ce7f f-fr f-mt10"><?= Yii::t('app', 'user_find_pay_pwd') ?></span>
			</div>

			<div class="f-mt30 f-pl15 f-pr15">
				<p class="f-fs16 fc-fff f-lh18"><?= Yii::t('app', 'key') . ' ' . Yii::t('app', 'sent') ?>:</p>
				<div class="fc-f5ce7f f-fs18 f-tc f-mt10 f-mb10"><?= $email ?></div>
				<ul class="f-mt20">
					<li class="f-mt15 f-pr">
						<input required id="pay_key" name="pay_key" type="password" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" title="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'key') ?>" placeholder="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'key') ?>"/>
					</li>
				</ul>
				<p class="f-fs13 f-lh18 fc-f5ce7f f-mt10">* <?= Yii::t('app', 'use_the_key_reset') ?></p>
			</div>

			<div class="f-pl15 f-pr15 f-mt15 ">
				<button class="btn f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 btn_yellow"><?= Yii::t('app', 'user_next') ?></button>
			</div>
		</form>	
    </div>
</div>
<!--内容结束-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript">
$(function(){
	var $form = $(find_paypwd).on('requestComplete', function(e, d){
		if (d.status === 1) {
			location.href = "<?= \yii\helpers\Url::toRoute('find-pay-pwd-reset') ?>";
		} else {
			msg.toast(d.info);
		}
	});
})
</script>
<?php $this->endBlock() ?>
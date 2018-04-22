<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_modify_pay_pwd');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/security-info') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'user_modify_pay_pwd')?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<!--内容开始-->
<div class="limit-size bg-bd0a2e limit-height">
	<form name="paypwd" data-ajax data-validate action="<?= \yii\helpers\Url::toRoute('update-pay-pwd') ?>" onsubmit="return false" method="post">
	<div class="f-p10 bordtot-890625">
		<ul>
			<li class="f-mt5 f-pr">
				<input type="password" name="pay_opwd" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" required title="<?= Yii::t('app', 'user_old_pay_pwd')?>" placeholder="<?= Yii::t('app', 'user_old_pay_pwd')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="password" name="pay_npwd" id="pay_npwd" pattern="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,}$" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" required title="<?= Yii::t('app', 'user_password_rule')?>" placeholder="<?= Yii::t('app', 'user_password_rule')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="password" name="pay_rnpwd" equalTo="#pay_npwd" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" required title="<?= Yii::t('app', 'user_pwd_reset')?>" placeholder="<?= Yii::t('app', 'user_pwd_reset')?>"/>
			</li>
		</ul>
		<p class="ff-mt15 fc-d5d5d5 f-mt10 f-fs15 f-lh18">*<?= Yii::t('app', 'user_password_rule')?></p>
		<div class="f-mt15">
			<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 reset_btn"><?= Yii::t('app', 'user_confirm_modify')?></button>
		</div>
		<div class="f-tc f-mt30 f-pl10 f-pr10 clearfix">
                <a href="<?= Url::toRoute('find-pay-pwd') ?>" class="fc-f5ce7f f-fs16"><?= Yii::t('app', 'user_find_pay_pwd')?></a>
        </div>
	</div>
	</form>	
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
	var $form = $(paypwd).on('requestComplete', function(e, d){
		if (d.status === 1) {
			msg.toast(d.info, 2000, function(){
				location.href = "<?= \yii\helpers\Url::toRoute('security-info') ?>";
			});
		} else {
			msg.toast(d.info);
		}
	});
})
</script>
<?php $this->endBlock() ?>
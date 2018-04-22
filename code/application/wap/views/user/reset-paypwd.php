<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_reset_pay_pwd');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/security-info') ?>" class="back"></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<!--内容开始-->
<div class="limit-size bg-bd0a2e limit-height">
	<div class="bordtot-890625 logo_div">
		<div class="clearfix f-pl15 f-pr15 ">
			<span><img src="<?= Yii::getAlias('@img') ?>/logo.png" class="f-w25"/></span>
			<span class="f-fs22 fc-f5ce7f f-fr f-mt10"><?= Yii::t('app', 'user_reset_pay_pwd') ?></span>
        </div>	

		<form name="reset_paypwd" data-ajax data-validate action="<?= \yii\helpers\Url::toRoute('find-pay-pwd-reset') ?>" onsubmit="return false" method="post">
			<div class="f-p10 bordtot-890625">
				<ul>
					<li class="f-mt5 f-pr">
						<input type="password" name="reset_pwd" id="reset_pwd" required pattern="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,}$" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" title="<?= Yii::t('app', 'user_password_rule')?>" placeholder="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'password') ?>"/>
					</li>
					<li class="f-mt15 f-pr">
						<input type="password" name="reset_rpwd" equalTo="#reset_pwd" required pattern="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,}$" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" title="<?= Yii::t('app', 'user_pwd_reset')?>" placeholder="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'confirm_password') ?>"/>
					</li>
				</ul>
				<p class="ff-mt15 fc-d5d5d5 f-mt10 f-fs15 f-lh18">*<?= Yii::t('app', 'user_password_rule') ?></p>
				<div class="f-mt15">
					<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 reset_btn"><?= Yii::t('app', 'reset') ?></button>
				</div>
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
	var $form = $(reset_paypwd).on('requestComplete', function(e, d){
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
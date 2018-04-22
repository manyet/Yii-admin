<?php
/* @var $this \yii\web\View */
$this->title = Yii::t('app', 'register');
?>

<?php $this->beginBlock('header') ?>
<a href="javascript:history.back();" class="back"></a>
<a href="<?= \yii\helpers\Url::toRoute('faq/index') ?>" class="fc-f5ce7f f-tdu f-fs14 btn_a"><?= Yii::t('app', 'top_faq') ?></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
    <div class="bordtot-890625 logo_div">
   	  	<div class="clearfix f-pl15 f-pr15 ">
			<span><img src="<?= Yii::getAlias('@img') ?>/logo.png" class="f-w25"/></span>
        	<span class="f-fs22 fc-f5ce7f f-fr f-mt15"><?= Yii::t('app', 'register') ?></span>
        </div>
        <form name="register" action="<?= \yii\helpers\Url::toRoute('submit-register') ?>" method="post" onsubmit="return false" data-ajax data-validate>
			<ul class="f-pl15 f-pr15 f-mt20">
				<li class="f-mt15 f-pr">
					<input autofocus name="username" pattern="^[a-zA-Z0-9]{1,12}$" required title="<?= Yii::t('app', 'username') . ' ' . Yii::t('app', 'format_error') ?>" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'create_username') ?>"/>
				</li>
				<li class="f-mt15 f-pr">
					<input name="email" required title="<?= Yii::t('app', 'email') . ' ' . Yii::t('app', 'format_error') ?>" pattern="email" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'verify_safe_email') ?>"/>
				</li>
				<li class="f-mt15 f-pr">
					<input name="invite_code" value="<?= Yii::$app->request->get('code', '') ?>" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'invitation_code') . Yii::t('app', 'optional') ?>"/>
				</li>
				<li class="f-mt15 clearfix">
					<input required title="<?= Yii::t('app', 'please_agree_the_agreement') ?>" name="agreement" id="agreement" type="checkbox" class="slecte_input" checked/>
					<label for="agreement" class="f-fs16 fc-fff"><?= Yii::t('app', 'i_agree') ?> <a href="<?= \yii\helpers\Url::toRoute(['agreement']) ?>" class="f-fs16 fc-f5ce7f f-tdu"><?= Yii::t('app', 'user_agreement') ?></a></label>
				</li>
			</ul>
			<div class="f-pl15 f-pr15 f-mt15 ">
				<button class="btn f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 btn_yellow"><?= Yii::t('app', 'register') ?></button>
			</div>
		</form>
        <div class="f-tc f-mt30 f-pl10 f-pr10 clearfix">
            <a href="<?= \yii\helpers\Url::toRoute(['login', 'returnUrl' => Yii::$app->homeUrl]) ?>" class="fc-f5ce7f f-fs16"><?= Yii::t('app', 'back_login') ?></a>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>
	
<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script type="text/javascript">
var $form = $(register).on('requestComplete', function(e, data){
	if (data.status === 1) {
		location.href = "<?= \yii\helpers\Url::toRoute('register-success') ?>";
	} else {
		msg.alert(data.info);
	}
});
</script>
<?php $this->endBlock() ?>
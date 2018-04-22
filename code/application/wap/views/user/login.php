<?php
/* @var $this \yii\web\View */
$this->title = Yii::t('app', 'login');
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
        	<span class="f-fs22 fc-f5ce7f f-fr f-mt15"><?= Yii::t('app', 'login') ?></span>
        </div>
        <form name="login" action="<?= \yii\helpers\Url::toRoute('submit-login') ?>" method="post" onsubmit="return false">
			<ul class="f-pl15 f-pr15 f-mt20">
				<li class="f-mt15 f-pr">
					<input name="username" required title="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'username') ?>" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'username') ?>" value="<?= isset($_COOKIE['fun']) ? $_COOKIE['fun'] : '' ?>"/>
				</li>
				<li class="f-mt15 f-pr">
					<input name="password" required title="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'password') ?>" type="password" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'password') ?>"/>
				</li>
				<li class="f-mt15 clearfix">
					<span class="f-w65 f-dib f-pr">
						<input name="vcode" required title="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'vcode') ?>" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'vcode') ?>"/>
					</span>
					<a class="f-w30 f-fr code_a"><?= \yii\captcha\Captcha::widget(['name'=>'captchaimg','captchaAction'=>'captcha','imageOptions'=>['id'=>'captchaimg'],'template'=>'{image}']) ?></a>
				</li>
				<li class="f-mt15 clearfix">
				  <span class="f-pt10 f-pb10 f-dib">
					  <input id="sd" type="checkbox" class="slecte_input" checked/>
					  <label for="sd" class="f-fs16 fc-fff"><?= Yii::t('app', 'stay_login') ?></label>
				  </span>
				  <a href="<?= yii\helpers\Url::toRoute('find-password') ?>" class="f-fr fc-f5ce7f f-fs16 f-pt10 f-pb10"><?= Yii::t('app', 'retrieve_password') ?></a>
			  </li>
			</ul>
			<div class="f-pl15 f-pr15 f-mt15">
				<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 log_btn"><?= Yii::t('app', 'login') ?></button>
			</div>
		</form>
        <div class="f-tc f-mt30 f-pl10 f-pr10 clearfix">
            <a href="<?= \yii\helpers\Url::toRoute('user/register') ?>" class="fc-f5ce7f f-fs16"><?= Yii::t('app', 'create_account') ?></a>
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
<script>
if (login.username.value) {
	login.password.focus();
} else {
	login.username.focus();
}

var $captcha = $('#captchaimg'), $form = $(login).myValidate(function(){
	var $submit = $form.find(':submit'), text = $submit.html();
	$.http.post($form[0].action, $form.serialize(), {
		before: function(){
			$submit.attr('disabled', '').html(text + '...');
		},
		success: function(data){
			if (data.status === 1) {
				msg.toast(data.info, 1000, function(){
					location.href = decodeURIComponent("<?= Yii::$app->request->get('returnUrl') ?>") || "<?= Yii::$app->request->referrer ?>" || "<?= Yii::$app->homeUrl ?>";
				});
			} else {
				login.vcode.value = "";
				$captcha.click();
				login.vcode.focus();
				msg.toast(data.info, 2000);
			}
		},
		after: function(){
			$submit.removeAttr('disabled').html(text);
		}
	});
});
</script>
<?php $this->endBlock() ?>
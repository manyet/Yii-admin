<?php
/* @var $this \yii\web\View */

$this->title = Yii::t('app', 'retrieve_password');

$url = \yii\helpers\Url::toRoute(['login', 'returnUrl' => Yii::$app->homeUrl]);
?>

<?php $this->beginBlock('header') ?>
<a href="<?= $url ?>" class="back"></a>
<a href="<?= \yii\helpers\Url::toRoute('faq/index') ?>" class="fc-f5ce7f f-tdu f-fs14 btn_a"><?= Yii::t('app', 'top_faq') ?></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
    <div class="bordtot-890625 logo_div">
   	  	<div class="clearfix f-pl15 f-pr15 ">
       	   <span><img src="<?= Yii::getAlias('@img') ?>/logo.png" class="f-w25"/></span>
        	<span class="f-fs22 fc-f5ce7f f-fr f-mt15"><?= Yii::t('app', 'retrieve_password') ?></span>
        </div>
		<form id="form" data-ajax data-validate onsubmit="return false" method="post">
        <ul class="f-pl15 f-pr15 f-mt20">
            <li class="f-mt15 f-pr">
                <input autofocus required name="username" title="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'username') ?>" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'username') ?>"/>
            </li>
            <li class="f-mt15 clearfix">
                <span class="f-w60 f-dib f-pr">
                	<input required name="vcode" title="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'vcode') ?>" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'vcode') ?>"/>
                </span>
                <a class="f-w30 f-fr code_a"><?= \yii\captcha\Captcha::widget(['name'=>'captchaimg','captchaAction'=>'captcha','imageOptions'=>['id'=>'captchaimg'],'template'=>'{image}']) ?></a>
            </li>
        </ul>
        <div class="f-pl15 f-pr15 f-mt15 ">
        	<button class="btn f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 btn_yellow"><?= Yii::t('app', 'user_next') ?></button>
        </div>
		</form>
        <div class="f-tc f-mt30 f-pl10 f-pr10 clearfix">
            <a href="<?= $url ?>" class="fc-f5ce7f f-fs16"><?= Yii::t('app', 'back_login') ?></a>
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
var $captchaImg = $('#captchaimg'), $captcha = $('[name="vcode"]');
$('#form').on('requestComplete', function(e, data){
	if (data.status === 1) {
		location.href = data.url;
	} else {
		$captchaImg.click();
		$captcha.val('');
		msg.toast(data.info);
	}
});
</script>
<?php $this->endBlock() ?>
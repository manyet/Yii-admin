<?php
/* @var $this \yii\web\View */

$this->title = Yii::t('app', 'retrieve_password');
?>

<?php $this->beginBlock('header') ?>
<a href="javascript:history.back();" class="back"></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
    <div class="bordtot-890625 logo_div">
   	  	<div class="clearfix f-pl15 f-pr15 ">
       	   <span><img src="<?= Yii::getAlias('@img') ?>/logo.png" class="f-w25"/></span>
        	<span class="f-fs22 fc-f5ce7f f-fr f-mt15"><?= Yii::t('app', 'retrieve_password') ?></span>
        </div>
        <form data-ajax data-validate method="post">
        <div class="f-mt30 f-pl15 f-pr15">
        	<p class="f-fs16 fc-fff f-lh18"><?= Yii::t('app', 'key') . ' ' . Yii::t('app', 'sent') ?>:</p>
            <div class="fc-f5ce7f f-fs18 f-tc f-mt10 f-mb10"><?= getHiddenEmail(session('password_email')) ?></div>
            <ul class="f-mt20">
                <li class="f-mt15 f-pr">
                    <input autofocus required name="key" title="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'key') ?>" type="text" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'key') ?>"/>
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
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php $this->endBlock() ?>
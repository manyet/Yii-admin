<?php
/* @var $this \yii\web\View */
$this->title = Yii::t('app', 'user_agreement');
?>

<?php $this->beginBlock('header') ?>
<a href="javascript:history.back();" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'user_agreement') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<div class="f-pl15 f-pr15 f-lh20 f-fs14 fc-fff f-mt10 f-mb10">
		<p><?= getDescription('register-protocol') ?></p>
    </div>
</div>
<?php $this->endBlock() ?>
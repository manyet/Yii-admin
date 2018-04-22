<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'about');

$config = get_system_config();
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'about') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
	<div class="f-p10 bordtot-890625">
		<div class="f-tc f-mt20"><img src="<?= Yii::getAlias('@img') ?>/logo.png"/></div>
		<p class="f-fs14 f-tc fc-fff f-mt5"><?= Yii::t('app', 'version') ?> <?= $config['SYSTEM_VERSION'] ?></p>
		<ul class="f-ml10 f-mr10 f-mt30 bg-fdedc9 f-br5 f-fs14">
			<li class="f-p10 bordtot-890625">
				<span><?= Yii::t('app', 'bottom_email') ?> : </span>
				<span><?= $config['CONTACT_EMAIL'] ?></span>
			</li>
			<li class="f-p10 bordtot-890625">
				<span><?= Yii::t('app', 'bottom_tel') ?> : </span>
				<span><?= $config['CONTACT_PHONE'] ?></span>
			</li>
			<li class="f-p10 bordtot-890625">
				<span><?= Yii::t('app', 'bottom_fax') ?> : </span>
				<span><?= $config['CONTACT_FAX'] ?></span>
			</li>
			<li class="f-p10 bordtot-890625">
				<p><?= Yii::t('app', 'bottom_address') ?> : </p>
				<p class="f-lh15 f-mt5"><?= $config['CONTACT_ADDRESS'] ?></p>
			</li>
		</ul>
	</div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>
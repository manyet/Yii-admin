<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'recast');

$get = Yii::$app->request->get();
$total = 0;
foreach ($get['pay'] as $value) {
	$total += $value;
}
?>

<?php $this->beginBlock('header') ?>
<a href="javascript:history.back();" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'Check_information') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<ul class="fc-fff f-fs14 f-pl10 f-pr10 bg-bd0a2e f-mt10">
		<li class="clearfix bordtot-890625 f-ptb8">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'this_recharge_time_get', ['score' => Yii::t('app', 'package_bonus_electron')]) ?></span>
			<span class="f-fr"><?= number_format($total * $user_info['electron_multiple'], 2) ?></span>
		</li>
	</ul>
	<form method="post" data-ajax data-validate action="<?= Url::toRoute('recast') ?>">
		<ul class="f-mt20 f-pl10 f-pr10">
			<li class="f-pr">
				<input autofocus type="password" name="password" required title="<?= Yii::t('app', 'transfer_payment') ?>" placeholder="<?= Yii::t('app', 'transfer_payment') ?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs"/>
			</li>
		</ul>
		<?php
		foreach ($get as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $k => $one) {
		?>
		<input type="hidden" name="<?= $key ?>[<?= $k ?>]" value="<?= $one ?>"/>
		<?php
			}
		} else {
		?>
		<input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
		<?php
			}
		}
		?>
		<div class="f-pl10 f-pr10">
			<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 f-mt20"><?= Yii::t('app', 'confirm_recast')?></button>
		</div>
    </form>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php $this->endBlock() ?>
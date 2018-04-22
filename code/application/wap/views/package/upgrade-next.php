<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
use common\services\RuleService;

$this->title = Yii::t('app', 'upgrade_package');

$get = Yii::$app->request->get();
?>

<?php $this->beginBlock('header') ?>
<a href="javascript:history.back();" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'Check_information') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<h2 class="fc-fff f-fs16 f-pt15 f-pb15 f-pl10"><?= Yii::t('app', 'original_package') ?></h2>
	<ul class="fc-fff f-fs14 f-pl10 f-pr10 bg-bd0a2e">
		<li class="clearfix bordtot-890625 f-ptb8">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_name')?></span>
			<span class="f-fr"><?= empty($my_package_info['package_name']) ? '/' : $my_package_info['package_name'] ?>(<?= empty($my_package_info['level_name']) ? '/' : $my_package_info['level_name'] ?>)</span>
		</li>
		<?php
		foreach ($get['pay'] as $key => $value) {
			if (floatval($value) > 0) {
		?>
		<li class="clearfix bordtot-890625 f-ptb8">
			<span class="fc-f5ce7f"><?= RuleService::getTypeName($key) ?></span>
			<span class="f-fr"><?= number_format($value, 2) ?></span>
		</li>
		<?php
			}
		}
		?>
	</ul>
	<h2 class="fc-fff f-fs16 f-pt15 f-pb15 f-pl10"><?= Yii::t('app', 'upgrade_package') ?></h2>
	<ul class="fc-fff f-fs14 f-pl10 f-pr10 bg-bd0a2e">
		<li class="clearfix bordtot-890625 f-ptb8">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_name')?></span>
			<span class="f-fr"><?= empty($up_package_info['package_name']) ? '/' : $up_package_info['package_name'] ?>(<?= empty($up_package_info['level_name']) ? '/' : $up_package_info['level_name'] ?>)</span>
		</li>
		<li class="clearfix bordtot-890625 f-ptb8">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_bonus_electron')?></span>
			<span class="f-fr"><?= number_format($up_package_info['package_value'] * $up_package_info['electron_multiple'], 2) ?></span>
		</li>
		<li class="clearfix bordtot-890625 f-ptb8">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_froze_electron')?></span>
			<span class="f-fr"><?= number_format($up_package_info['package_value'] * $up_package_info['electron_multiple'], 2) ?></span>
		</li>
	</ul>
	<form method="post" data-ajax data-validate action="<?= Url::toRoute('upgrade') ?>">
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
			<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 f-mt20"><?= Yii::t('app', 'confirm_upgrade')?></button>
		</div>
    </form>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php $this->endBlock() ?>
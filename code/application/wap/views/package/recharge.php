<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
use common\services\RuleService;

$this->title = Yii::t('app', 'package_recharge');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('package/my') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'package_recharge') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
	<table class="f-w100 f-tc fc-333 f-fs14 bg-fdedc9">
		<tbody>
			<tr>
				<td class="f-w33 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_name')?></td>
				<td class="f-w33 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_level_name')?></td>
				<td class="f-w33 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_electron_multiplier')?></td>
			</tr>
			<tr>
				<td class="f-w33 f-ptb8 bordb-ffb200"><?= empty($my_package_info['package_name']) ? '/' : $my_package_info['package_name'] ?></td>
				<td class="f-w33 f-ptb8 bordb-ffb200"><?= empty($my_package_info['level_name']) ? '/' : $my_package_info['level_name'] ?></td>
				<td class="f-w33 f-ptb8 bordb-ffb200"><?= empty($user_info['electron_multiple']) ? '/' : $user_info['electron_multiple'] ?></td>
			</tr>
		</tbody>
	</table>
    <form id="form-recharge" method="get" data-validate action="<?= yii\helpers\Url::toRoute('recharge-next') ?>" onsubmit="return false">
		<ul class="bg-c32545 f-pt5 f-pb15 f-pl10 f-pr10">
			<?php
			foreach ($recharge_rules as $one) {
				$multiple = 100;
				$placeholder = Yii::t('app', 'please_enter_score', ['score' => RuleService::getTypeName($one['id']), 'multiple' => $multiple]);
				if (floatval($one['recharge_lowest_value']) > 0) {
					$placeholder .= ', ' . Yii::t('app', 'at_least_use', ['value' => number_format($one['recharge_lowest_value'], 2), 'score' => '']);
				}
			?>
        	<li class="f-fs14 fc-fff f-pt5 f-pb5 f-mt10">
            	<span><?= RuleService::getTypeName($one['id']) ?> : </span>
                <span><?= number_format($user_info[RuleService::getBalanceKey($one['id'])], 2) ?></span>
				<div class="f-pr f-mt5">
					<input data-min-percentage="<?= $one['recharge_lowest_ratio'] ?>" data-max-percentage="<?= $one['recharge_highest_ratio'] ?>" class="f-w100 f-bs f-ptb8 f-fs14 bg-fff f-pl5 bd-yellow" type="text" mt="<?= $multiple ?>"<?php if ($one['recharge_lowest_ratio'] > 0 || $one['recharge_lowest_value'] > 0) { echo ' required'; } ?>  min="<?=  $one['recharge_lowest_value'] ?>" name="pay[<?= $one['id'] ?>]" data-recharge pattern="^([1-9][0-9]*)|0$" title="<?= Yii::t('app', 'please_check_score', ['score' => RuleService::getTypeName($one['id']), 'multiple' => $multiple]) ?>" placeholder="<?= $placeholder ?>"/>
				</div>
            </li>
			<?php } ?>
		</ul>
		<div class="f-mt20 f-pb20 f-tc f-pl10 f-pr10">
			<button class="btn btn_yellow f-w100 f-db f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5"><?= Yii::t('app', 'user_next') ?></button>
		</div>
	</form>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php
$arr = RuleService::getBalanceInfo($user_info);
?>
<script type="text/javascript">
var $form = $('#form-recharge').myValidate(function(){
	var total = 0, text, $input = $form.find('[data-recharge]').each(function(){
		var value = parseFloat(this.value || 0);
		if (this.value) {
			if (value > balances[this.name]) {
				text = "<?= Yii::t('app', 'balance_not_enough') ?>".replace('{score}', scoreNames[this.name]);
				return false;
			}
			total += value;
		}
	});
	if (text) {
		msg.toast(text);
		return;
	}
	$input.each(function(){
		var value = parseFloat(this.value || 0), $this = $(this), minPercentage = $this.data('min-percentage'), maxPercentage = $this.data('max-percentage');
		if (value < total * minPercentage / 100) {
			text = "<?= Yii::t('app', 'at_least_use') ?>".replace('{score}', scoreNames[this.name]).replace('{value}', minPercentage + '%');
			return false;
		}
		if (value > total * maxPercentage / 100) {
			text = "<?= Yii::t('app', 'at_most_use') ?>".replace('{score}', scoreNames[this.name]).replace('{value}', maxPercentage + '%');
			return false;
		}
	});
	if (text) {
		msg.toast(text);
		return;
	}
	location.href = $form[0].action + '?' + $form.serialize();
}), balances = <?= json_encode($arr['balances']) ?>, scoreNames = <?= json_encode($arr['scoreNames']) ?>;
</script>
<?php $this->endBlock() ?>
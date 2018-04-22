<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
use common\services\RuleService;

$this->title = Yii::t('app', 'upgrade_package');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('package/my') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'upgrade_package') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">

	<div class="bg-bd0a2e bordtot-890625">
    	
        <table class="f-w100 f-tc fc-333 f-fs14 bg-fdedc9">
        	<tbody>
            	<tr>
                	<td class="f-w50 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_name')?></td>
                    <td class="f-w50 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_level_name')?></td>
                </tr>
                <tr>
                	<td class="f-w50 f-ptb8 bordb-ffb200"><?= empty($my_package_info['package_name']) ? '/' : $my_package_info['package_name'] ?></td>
                    <td class="f-w50 f-ptb8 bordb-ffb200"><?= empty($my_package_info['level_name']) ? '/' : $my_package_info['level_name'] ?></td>
                </tr>
            </tbody>
        </table>
        <form id="form-upgrade" method="get" data-validate action="<?= yii\helpers\Url::toRoute('upgrade-next') ?>" onsubmit="return false">
			<ul class="bg-c32545 f-pt15 f-pb15 f-pl10 f-pr10">
				<li class="f-fs14 fc-fff f-pt5 f-pb5">
					<select id="select-package" name="package" required title="<?= Yii::t('app', 'please_select_upgrade_package') ?>" class="f-w100 f-bs f-ptb8 f-fs14 bg-fff f-pl5 bd-yellow">
						<option value=""><?= Yii::t('app', 'please_select_upgrade_package') ?></option>
						<?php foreach ($available_package as $one) { ?>
						<option value="<?= $one['id'] ?>" data-price="<?= $one['package_value'] ?>" data-name="<?= $one['level_name'] ?>"><?= $one['package_name'] ?> $<?= $one['package_value'] ?></option>
						<?php } ?>
					</select>
				</li>
				<?php
				foreach ($upgrade_rules as $one) {
					$upgrade_multiple = 100;
				?>
				<li class="f-fs14 fc-fff f-pt5 f-pb5 f-mt10">
					<span><?= RuleService::getTypeName($one['id']) ?> : </span>
					<span><?= number_format($user_info[RuleService::getBalanceKey($one['id'])], 2) ?></span>
					<div class="f-pr f-mt5">
						<input class="f-w100 f-bs f-ptb8 f-fs14 bg-fff f-pl5 bd-yellow" type="text" data-min-percentage="<?= $one['package_lowest_ratio'] / 100 ?>" data-max-percentage="<?= $one['package_highest_ratio'] / 100 ?>" data-buy mt="<?= $upgrade_multiple ?>"<?php if ($one['package_lowest_ratio'] > 0) { echo ' required'; } ?> name="pay[<?= $one['id'] ?>]" pattern="^([1-9][0-9]*)|0$" title="<?= Yii::t('app', 'please_check_score', ['score' => RuleService::getTypeName($one['id']), 'multiple' => $upgrade_multiple]) ?>" placeholder="<?= Yii::t('app', 'please_enter_score', ['score' => RuleService::getTypeName($one['id']), 'multiple' => $upgrade_multiple]) ?>"/>
					</div>
				</li>
				<?php } ?>
			</ul>
			<div class="f-mt20 f-pb20 f-tc f-pl10 f-pr10">
				<button class="btn btn_yellow f-w100 f-db f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5"><?= Yii::t('app', 'user_next') ?></button>
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
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/helper.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php
$arr = RuleService::getBalanceInfo($user_info);
?>
<script type="text/javascript">
var $form = $('#form-upgrade').myValidate(function(){
	var $selected = $package.children(':selected'), price = parseFloat($selected.data('price')), total = 0, text;
	$form.find('[data-buy]').each(function(){
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
	if(price != total) {
		msg.toast('<?= Yii::t('app', 'money_sum_error') ?>');
		return;
	}
	location.href = $form[0].action + '?' + $form.serialize();
}), balances = <?= json_encode($arr['balances']) ?>, scoreNames = <?= json_encode($arr['scoreNames']) ?>, $package = $('#select-package').change(function(){
	var $selected = $(this).children(':selected'), price = parseFloat($selected.data('price'));
	$form.find('[data-buy]').each(function(){
		var $this = $(this), max = price * $this.data('max-percentage'), min = price * $this.data('min-percentage'),
			text = "<?= Yii::t('app', 'please_enter_score', ['multiple' => $upgrade_multiple]) ?>".replace('{score}', scoreNames[this.name]);
		$this.attr('max', max).attr('min', min);
		if ($package.val()) {
			text += ", <?= Yii::t('app', 'can_use') ?>".replace('{min}', helper.moneyFormat(min, 2)).replace('{max}', helper.moneyFormat(max, 2));
		}
		$this.attr('placeholder', text);
	});
});
</script>
<?php $this->endBlock() ?>
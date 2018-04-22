<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
use common\services\RuleService;

$this->title = Yii::t('app', 'package_buy');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::home() ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'package_buy') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
	<div class="bg-bd0a2e bordtot-890625">
        <table class="f-w100 f-tc fc-333 f-fs14 bg-fdedc9">
            <tbody>
                <tr>
                    <td class="f-w33 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_name')?></td>
                    <td class="f-w33 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_level_name')?></td>
                    <td class="f-w33 f-ptb8 bg-f8d788 f-fwb bordb-ffb200"><?= Yii::t('app', 'package_value')?></td>
                </tr>
                <tr>
                    <td class="f-ptb8 bordb-ffb200"><?= $package_info['package_name'] ?></td>
                    <td class="f-ptb8 bordb-ffb200"><?= $package_info['level_name'] ?></td>
                    <td class="f-ptb8 bordb-ffb200">$<?= number_format($package_info['package_value'], 2) ?></td>
                </tr>
            </tbody>
        </table>
		<form id="form-buy" method="post" data-validate action="<?= yii\helpers\Url::toRoute('buy') ?>" onsubmit="return false">
        <ul class=" bg-c32545 f-pt5 f-pb15 f-pl10 f-pr10">
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
        <ul class="f-pl10 f-pr10">
        	<li class="f-mt15 f-pr">
                <input required name="password" title="<?= Yii::t('app', 'transfer_payment') ?>" type="password" class="f-w100 f-bs f-ptb8 f-fs14 bg-fff f-pl5 bd-yellow" placeholder="<?= Yii::t('app', 'transfer_payment') ?>"/>
            </li>
        </ul>
        <div class="f-mt20 f-pb20 f-tc f-pl10 f-pr10">
			<input type="hidden" name="package" value="<?= $package_info['id'] ?>"/>
            <button class="btn btn_yellow f-w100 f-db f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5"><?= Yii::t('app', 'confirm_buy') ?></button>
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
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php
$arr = RuleService::getBalanceInfo($user_info);
?>
<script type="text/javascript">
var $form = $('#form-buy').myValidate(function(){
	var price = <?= $package_info['package_value'] ?>, total = 0, text;
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
	$.http.post($form[0].action, $form.serialize(), function(d){
		if (d.status === 1) {
			msg.toast(d.info, function(){
				location.href = d.url;
			});
		} else {
			msg.toast(d.info, 2000);
		}
	});
}), balances = <?= json_encode($arr['balances']) ?>, scoreNames = <?= json_encode($arr['scoreNames']) ?>;
</script>
<?php $this->endBlock() ?>
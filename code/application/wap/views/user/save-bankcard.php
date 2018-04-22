<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_setting_bank_card');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/security-info') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'user_setting_bank_card')?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<!--内容开始-->
<div class="limit-size bg-bd0a2e limit-height">
	<form name="save_bankcard" data-ajax data-validate action="<?= \yii\helpers\Url::toRoute('save-bank-card') ?>" onsubmit="return false" method="post">
	<div class="f-p10 bordtot-890625">
		<ul>
			<li class="f-mt5 f-pr">
				<input type="text" name="bank_name" required title="<?= Yii::t('app', 'user_bank_name')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'user_bank_name')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="text" name="branch" title="<?= Yii::t('app', 'user_bank_branch')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'user_bank_branch')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="text" name="account_holder" required title="<?= Yii::t('app', 'user_cardholder_name')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'user_cardholder_name')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="text" name="card_number" id="card_number" required title="<?= Yii::t('app', 'user_bank_card_number')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'user_bank_card_number')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="text" name="rcard_number" equalTo="#card_number" required title="<?= Yii::t('app', 'user_bank_card_reset')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'user_bank_card_reset')?>"/>
			</li>
		</ul>
		<p class="ff-mt15 fc-d5d5d5 f-mt10 f-fs15 f-lh18">*<?= Yii::t('app', 'user_check_bank')?></p>
		<div class="f-mt15">
			<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 reset_btn"><?= Yii::t('app', 'user_save')?></button>
		</div>
	</div>
	</form>	
</div>
<!--内容结束-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript">
$(function(){
	var $form = $(save_bankcard).on('requestComplete', function(e, d){
		if (d.status === 1) {
			msg.toast(d.info, 2000, function(){
				location.href = "<?= \yii\helpers\Url::toRoute('security-info') ?>";
			});
		} else {
			msg.toast(d.info);
		}
	});
})
</script>
<?php $this->endBlock() ?>
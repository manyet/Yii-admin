<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'wap_exchange');
?>
<?php $this->beginBlock('header') ?>
    <h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'wap_exchange') ?></h2>
    <a href="<?= Url::toRoute('record') ?>" class="exchange_list"></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
    <div class="fc-fff f-fs14 bg-c32545 f-pl10 f-pr10 f-pt15 f-pb15 f-tc">
        <p class="f-fs16 f-mt5"><?=Yii::t('app','wap_exchange_score')?></p>
        <div class="f-fs22 f-mt10 f-mb5"><?= number_format($user_info['entertainment_integral'], 2) ?></div>
    </div>
    <div class="bg-bd0a2e f-pl15 f-pr15 f-pt20 f-pb20 fc-fff f-fs16">
        <h2 class="fc-f5ce7f f-fwb f-fs16 f-mt15"><?=Yii::t('app','wap_exchange_set')?></h2>
		<form id="exchange" data-bound data-ajax data-validate action="<?= Url::toRoute('verify') ?>" method="post" onsubmit="return false">
        <ul>
            <li class="f-mt15 f-pr">
                <input autofocus name="amount" required min="0" mt="1" title="<?=Yii::t('app','wap_exchange_point_error')?>" type="number" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','wap_exchange_point')?>"/>
            </li>
            <li class="f-mt15 f-pr">
                <input type="text" name="remark" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','wap_exchange_remarks')?>"/>
            </li>
        </ul>
        <p class="f-fs14 f-lh15 fc-d5d5d5 f-mt10"><?=Yii::t('app','wap_exchange_prompt')?></p>
        <div class="f-mt15">
            <button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 next_btn"><?=Yii::t('app','user_next')?></button>
        </div>
		</form>
    </div>
    <div style="height:8rem;"></div><!--底部导航撑开高度--需有-->
</div>
<?= $this->render('//layouts/footer', ['selected' => 'exchange']) ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script>
var $form = $('#exchange').myValidate(function(){
	msg.confirm("<?=Yii::t('app','wap_exchange_confirm_prompt')?>", function() {
		$.http.post($form[0].action, $form.serialize(), function(d){
			if (d.status === 1) {
				location.href = d.url;
			} else {
				msg.toast(d.info);
			}
		});
	});
});
</script>
<?php $this->endBlock() ?>


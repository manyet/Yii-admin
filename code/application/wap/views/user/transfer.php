<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'wap_transfer');
?>
<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute($Url) ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'wap_transfer') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
	<p class="bg-c32545 fc-fff f-fs14 f-lh15 f-p10">
		<?=Yii::t('app','transfer_rules')?>：
		<?php if($rule['company_score_ratio']>0){?>
		   <?= Yii::t('app', 'transfer_to')?><?= Yii::t('app', 'transfer_branch')?><?= Yii::t('app', 'transfer_rate')?><?=$rule['company_score_ratio']?>%
		<?php } ?><?php if($rule['cash_score_ratio']>0){?>
		   <?= Yii::t('app', 'transfer_to')?><?= Yii::t('app', 'transfer_cash')?><?= Yii::t('app', 'transfer_rate')?><?=$rule['cash_score_ratio']?>%
		<?php } ?><?php if($rule['entertainment_score_ratio']>0){?>
			<?= Yii::t('app', 'transfer_to')?><?= Yii::t('app', 'transfer_score')?><?= Yii::t('app', 'transfer_rate')?><?=$rule['entertainment_score_ratio']?>%
		<?php } ?>
	</p>
    <form data-ajax data-validate data-error-element="#error" action="<?= Url::toRoute('sure') ?>" method="post" onsubmit="return false;">
    <ul class="f-pl15 f-pr15 f-mt20">
        <li class="f-mt15 f-pr">
            <input type="text" name="uname" required title="<?=Yii::t('app','transfer_uname')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs uname" placeholder="<?= Yii::t('app', 'transfer_uname')?>"/>
        </li>
        <li class="f-mt15 f-pr">
            <input type="text" name="name" required title="<?=Yii::t('app','transfer_name')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs name" placeholder="<?= Yii::t('app', 'transfer_name')?>"/>
        </li>
        <li class="f-mt15 f-pr">
            <input type="number" name="value" required mt="<?=$rule['transfer_multiple']?>" min="<?=$rule['transfer_lowest_value']?>" title="<?= Yii::t('app', 'please_enter_transfer_score', ['multiple' => $rule['transfer_multiple']]) ?>,<?= Yii::t('app', 'at_least_use', ['value' => $rule['transfer_lowest_value'],'score' => '']) ?>"
                   class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs value"
                   placeholder="<?= Yii::t('app', 'please_enter_transfer_score', ['multiple' => $rule['transfer_multiple']]) ?>,<?= Yii::t('app', 'at_least_use', ['value' => $rule['transfer_lowest_value'],'score' => '']) ?>"/>
        </li>
        <input hidden name="id" value="<?=$rule['id']?>">
        <div class="fc-fff f-fs16 f-tc f-mdFont f-mt15 hide" id="error"></div>
    </ul>
    <div class="f-pl15 f-pr15 f-mt20 f-tc">
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
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php $this->endBlock() ?>
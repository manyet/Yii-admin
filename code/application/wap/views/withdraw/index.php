<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'withdraw_bank_presentation');
$get = \Yii::$app->request->get();
if ($get['id']==1){
    $Url=Url::toRoute('user/cash');
}if ($get['id']==2){
    $Url=Url::toRoute('user/dividend');
}
?>
<?php $this->beginBlock('header') ?>
    <a href="<?= $Url ?>" class="back"></a>
    <h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'withdraw_bank_presentation') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">

    <p class="bg-c32545 fc-fff f-fs14 f-lh15 f-p10"><?= getDescription('withdrawals-reward') ?></p>
    <form data-ajax data-validate data-error-element="#error" action="<?= Url::toRoute('sure') ?>" method="post" onsubmit="return false;">

    <ul class="f-pl15 f-pr15 f-mt20">
        <li class="f-mt15 f-pr">
            <input type="text" name="bank" required value="<?=empty($bank['bank_name']) ? '' : $bank['bank_name'];?>" title="<?=Yii::t('app','withdraw_bank')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','withdraw_bank')?>"/>
<!--        <span class="bg-bd0a2e f-fs13 fc-fff warning_span">!</span>-->
    </li>
    <li class="f-mt15 f-pr">
        <input type="text" name="branch" value="<?=empty($bank['branch']) ? '' : $bank['branch'];?>"  class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','withdraw_branch')?>"/>
<!--        <span class="bg-bd0a2e f-fs13 fc-fff warning_span">!</span>-->
    </li>
    <li class="f-mt15 f-pr">
        <input type="text" name="holder" required value="<?=empty($bank['account_holder']) ? '' : $bank['account_holder'];?>" title="<?=Yii::t('app','withdraw_bank_holder')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','withdraw_bank_holder')?>"/>
<!--        <span class="bg-bd0a2e f-fs13 fc-fff warning_span">!</span>-->
    </li>
    <li class="f-mt15 f-pr">
        <input type="text" name="bank_no" required  value="<?=empty($bank['card_number']) ? '' : $bank['card_number'];?>" title="<?=Yii::t('app','withdraw_bank_no')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','withdraw_bank_no')?>"/>
<!--        <span class="bg-bd0a2e f-fs13 fc-fff warning_span">!</span>-->
    </li>
    <li class="f-mt15 f-pr">
        <input type="text" name="money"  required mt="100" min="100" title="<?=Yii::t('app','withdraw_bank_money')?>" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','withdraw_bank_money')?>"/>
<!--        <span class="bg-bd0a2e f-fs13 fc-fff warning_span">!</span>-->
    </li>
    <li class="f-mt15 f-pr">
        <select class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" name="rate">
            <?php foreach ($exchange as $item){?>
                <option value="<?=$item['id']?>" data-in="<?=$item['buy_exchange_rate']?>"  data-name="<?= useCommonLanguage() ? $item['e_currency'] : $item['currency'] ?>"
                        data-out="<?=$item['sell_exchange_rate']?>"><?= useCommonLanguage() ? $item['e_currency'] : $item['currency'] ?></option>
            <?php } ?>
        </select>
    </li>
        <div class="fc-fff f-fs16 f-tc f-mdFont f-mt15 hide" id="error"></div>
        <input name="id" type="hidden" value="<?=$get['id']?>" />
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

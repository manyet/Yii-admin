<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$get = \Yii::$app->request->get();
$this->title = Yii::t('app', 'wap_withdraw_check');
?>
<?php $this->beginBlock('header') ?>
    <a href="<?= Url::toRoute(['index','id'=>$get['id']]) ?>" class="back"></a>
    <h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'wap_withdraw_check') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
    <form data-ajax data-validate data-error-element="#error" action="<?= Url::toRoute('extract') ?>" method="post" onsubmit="return false;">
        <div class="limit-size">
            <ul class="fc-fff f-fs14 f-pl10 f-pr10 bg-bd0a2e f-mt10">
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','check_bank')?></span>
                    <span class="f-fr"><?=$get['bank']?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','check_branch')?></span>
                    <span class="f-fr"><?=$get['branch']?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','check_bank_no')?></span>
                    <span class="f-fr"><?=$get['bank_no']?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','check_bank_holder')?></span>
                    <span class="f-fr"><?=$get['holder']?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','withdraw_bank_score')?></span>
                    <span class="f-fr"><?= number_format($get['money'], 2) ?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <?php if ($get['id']==1){ ?>
                    <span class="fc-f5ce7f"><?=Yii::t('app','withdraw_bank_withdrawal')?></span>
                    <?php }else{ ?>
                        <span class="fc-f5ce7f"><?=Yii::t('app','withdraw_bank_withdrawals')?></span>
                    <?php } ?>
                    <span class="f-fr"><?= number_format($money, 2) ?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','withdraw_bank_rate')?></span>
                    <span class="f-fr"><?= useCommonLanguage() ? $rate['e_currency'] : $rate['currency'] ?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','withdraw_bank_Exchange')?></span>
                    <span class="f-fr">1:<?=$rate['sell_exchange_rate']?></span>
                </li>
                <li class="clearfix bordtot-890625 f-ptb8">
                    <span class="fc-f5ce7f"><?=Yii::t('app','withdraw_bank_due')?></span>
                    <span class="f-fr"><?=number_format($rate['sell_exchange_rate']*$get['money'], 2)?></span>
                </li>
                <input type="hidden" name="withdrawal_type" value="<?=$get['id']?>"/>
                <input type="hidden" name="bank" value="<?=$get['bank']?>"/>
                <input type="hidden" name="branch" value="<?=$get['branch']?>"/>
                <input type="hidden" name="bank_no" value="<?=$get['bank_no']?>"/>
                <input type="hidden" name="holder" value="<?=$get['holder']?>"/>
                <input type="hidden" name="rate" value="<?=$rate['id']?>"/>
                <input type="hidden" name="rate" value="<?=$rate['id']?>"/>
                <input type="hidden" name="out_integral" value="<?=$rate['sell_exchange_rate']*$get['money']?>"/>
                <input type="hidden" name="money" value="<?=$get['money']?>"/>
            </ul>

            <ul class="f-mt20 f-pl10 f-pr10">
                <li class="f-pr">
                    <input type="password" name="pass" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','transfer_payment')?>"/>
                    <!--            <span class="bg-bd0a2e f-fs13 fc-fff warning_span">!</span>-->
                </li>
            </ul>
            <div class="f-pl10 f-pr10">
                <button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 f-mt20"><?=Yii::t('app','Submit')?></button>
            </div>

        </div>
    </form>
    <!--成功或错误的弹窗开始-->
    <span class="pop_cuo fc-fff f-tc f-fs16 f-br5 hide">Operation succeeds!</span>
    <!--成功或错误的弹窗结束-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
    <script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
    <script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
    <script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
    <script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php $this->endBlock() ?>
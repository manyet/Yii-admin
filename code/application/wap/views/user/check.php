<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$get = \Yii::$app->request->get();
$this->title = Yii::t('app', 'wap_transfer_check');
?>
<?php $this->beginBlock('header') ?>
    <a href="<?= Url::toRoute(['transfer','id'=>$get['id']]) ?>" class="back"></a>
    <h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'wap_transfer_check') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<form data-ajax data-validate data-error-element="#error" action="<?= Url::toRoute('sure-submit') ?>" method="post" onsubmit="return false;">
    <div class="limit-size">
        <ul class="fc-fff f-fs14 f-pl10 f-pr10 bg-bd0a2e f-mt10">
            <li class="clearfix bordtot-890625 f-ptb8">
            <span class="fc-f5ce7f"><?=Yii::t('app','transfer_account')?></span>
            <span class="f-fr"><?=$user['uname']?></span>
            </li>
            <li class="clearfix bordtot-890625 f-ptb8">
                <span class="fc-f5ce7f"><?=Yii::t('app','transfer_account_name')?></span>
                <span class="f-fr"><?=$user['realname']?></span>
            </li>
            <li class="clearfix bordtot-890625 f-ptb8">
                <span class="fc-f5ce7f"><?=Yii::t('app','transfer_from')?></span>
                <span class="f-fr"><?=$title?></span>
            </li>
            <li class="clearfix bordtot-890625 f-ptb8">
                <span class="fc-f5ce7f"><?=Yii::t('app','transfer_out_score')?></span>
                <span class="f-fr"><?= number_format($get['value'], 2) ?></span>
            </li>
            <li class="clearfix bordtot-890625 f-ptb8">
                <span class="fc-f5ce7f"><?=Yii::t('app','transfer_balance')?></span>
                <span class="f-fr"><?= number_format($integral, 2) ?></span>
            </li>
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="uid" value="<?=$user['id']?>">
            <input type="hidden" name="integral" value="<?=$get['value']?>">
        </ul>

    <ul class="f-mt20 f-pl10 f-pr10">
        <li class="f-pr">
            <input type="password" name="password" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?=Yii::t('app','transfer_payment')?>"/>
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
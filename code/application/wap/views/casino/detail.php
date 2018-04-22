<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'top_casino');
?>
<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'casino') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size f-pb20">
    <div><img src="<?=$detail['casino_picture']?>" class="f-w100"/></div>
    <div class="bg-bd0a2e f-pl10 f-pr10 f-pb10 f-fs14">
        <p class="f-pt10">
            <span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'casino_name') ?> </span>
            <span class="fc-fff"><?= useCommonLanguage() ? $detail['e_casino_name'] : $detail['casino_name'] ?></span>
        </p>
        <p class="f-pt10">
            <span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'casino_country') ?> </span>
            <span class="fc-fff"><?= useCommonLanguage() ? $detail['e_from'] : $detail['from'] ?></span>
        </p>
        <p class="f-pt10">
            <span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'casino_location') ?> </span>
            <span class="fc-fff"><?= useCommonLanguage() ? $detail['e_position'] : $detail['position'] ?></span>
        </p>
        <p class="f-pt10">
            <span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'casino_entertainment') ?> </span>
            <span class="fc-fff"><?= useCommonLanguage() ? $detail['e_projects'] : $detail['projects'] ?></span>
        </p>
    </div>
    <!--图文展示开始-->
    <div class="fc-fff bg-bd0a2e f-mt15 f-bs f-p10 casino_detail"><?= useCommonLanguage() ? $detail['e_details'] : $detail['details'] ?></div>
    <!--图文展示开始-->
</div>
<?php $this->endBlock() ?>

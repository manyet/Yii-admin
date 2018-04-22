<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$get = Yii::$app->request->get();
$this->title = Yii::t('app', 'wap_rule');
?>
<?php $this->beginBlock('header') ?>
    <a href="<?= Url::toRoute('index') ?>" class="back"></a>
    <h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'wap_rule') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
    <div><img src="<?=$features['features_Picture'.$get['id']]?>" class="f-w100"/></div>
    <p class="f-pl10 f-pr10 f-pt10 f-pb20 f-lh20 f-fs14 fc-fff"><?= useCommonLanguage() ? $features['e_details'.$get['id']] : $features['details'.$get['id']] ?></p>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>


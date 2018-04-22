<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'notice_wap_detail');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('notice/index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'notice_wap_detail')?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<div class="f-ml15 f-mr15 f-mt15">
		<h3 class="f-fs15 f-fwb fc-f5ce7f"><?= $title?></h3>
		<h2 class="f-fs14 fc-d5d5d5 f-mt5"><?= date('Y-m-d H:m:s', $create_time)?></h2>
        <p class="f-lh15 f-fs14 f-mt10 bg-fdedc9 f-p10"><?= $content?></p>
    </div>
</div>
<?php $this->endBlock() ?>
<?php
$this->title = $msgTitle;

$this->beginBlock('container')
?>
<div class="limit-size">
	<div class="f-tc f-pt20 f-mt30"><img src="<?= Yii::getAlias('@img') ?>/error.png" class="f-w45 f-mt20"/></div>
    <p class="f-fs16 f-tc fc-fff f-mt10"><?= $message ?></p>
	<div class="f-mt30 f-tc">
		<a class="btn btn_red f-w40 f-fs14 f-pt10 f-pb10 fc-fff f-br5 f-dib" href="<?= $jumpUrl ?>"><?= Yii::t('app', 'back') ?></a>
    </div>
</div>
<?php $this->endBlock() ?>
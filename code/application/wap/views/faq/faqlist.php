<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', $type);
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', $type) ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<ul class="bg-bd0a2e">
		<?php foreach ($result as $key =>$item){ ?>
		<li class="bordtot-890625 f-p10">
			<div class="f-fs15 fc-fff f-pr faq_li_div">
				<span class="bg-f8d788 f-fs15 fc-960e2a faq_li_mun"><?=$key+1?></span>
				<h2 class="f-lh15 f-fwb"><?= useCommonLanguage() ? $item['equestion'] : $item['question'] ?></h2>
			</div>
			<p class="f-fs14 fc-d5d5d5 f-lh15 f-mt5"><?= useCommonLanguage() ? $item['eanswer'] : $item['answer'] ?></p>
		</li>
		<?php } ?>
	</ul>
</div>
<?php $this->endBlock() ?>
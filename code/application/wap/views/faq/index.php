<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'top_faq');
?>

<?php $this->beginBlock('header') ?>
<a href="javascript:history.back();" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'top_faq') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<h2 class="fc-fff f-fs15 f-mt15 f-mb15 f-pl10"><?=Yii::t('app','wap_faq_type')?></h2>
	<ul class="bg-bd0a2e">
		<?php foreach ($result as $item){ ?>
		<li class="bordtot-890625">
			<a href="<?= Url::toRoute(['faqlist', 'id' =>$item['id']]) ?>" class="f-db fc-fff f-fs15 f-p10 f-lh18"><?= useCommonLanguage() ? $item['type_ename'] : $item['type_name'] ?></a>
		</li>
	<?php } ?>
	</ul>
</div>
<?php $this->endBlock() ?>
<?php
if (!isset($selected)) {
	$selected = '';
}
?>
<!--底部导航开始-->
<footer class="footer">
	<ul class="clearfix">
    	<li class="f-w20 f-fl f-tc footer_li01<?php if ($selected === 'home') { ?> sel<?php } ?>">
			<a href="<?= yii\helpers\Url::home() ?>" class="f-db f-fs13"><?= Yii::t('app', 'home') ?></a>
        </li>
        <li class="f-w20 f-fl f-tc footer_li02<?php if ($selected === 'casino') { ?> sel<?php } ?>">
			<a href="<?= yii\helpers\Url::toRoute('casino/index') ?>" class="f-db f-fs13"><?= Yii::t('app', 'casino') ?></a>
        </li>
        <li class="f-w20 f-fl f-tc f-pr footer_li03<?php if ($selected === 'exchange') { ?> sel<?php } ?>">
        	<a href="<?= yii\helpers\Url::toRoute('exchange/index') ?>" class="f-db f-fs13"><?= Yii::t('app', 'exchange') ?></a>
        </li>
        <li class="f-w20 f-fl f-tc footer_li04<?php if ($selected === 'invest') { ?> sel<?php } ?>">
        	<a href="<?= yii\helpers\Url::toRoute('investment/index') ?>" class="f-db f-fs13"><?= Yii::t('app', 'invest') ?></a>
        </li>
        <li class="f-w20 f-fl f-tc footer_li05<?php if ($selected === 'my') { ?> sel<?php } ?>">
        	<a href="<?= yii\helpers\Url::toRoute('user/index') ?>" class="f-db f-fs13"><?= Yii::t('app', 'my') ?></a>
        </li>
    </ul>
</footer>
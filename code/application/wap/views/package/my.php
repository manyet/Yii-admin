<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'package_my_package');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'package_my_package') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<?php if (!empty($my_package_info)) { ?>
	<ul class="f-ml10 f-mr10 f-mt10 f-pb20 fc-fff">
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_name')?> : </span>
			<span><?= $my_package_info['package_name'] ?></span>
		</li>
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_level_name')?> : </span>
			<span><?= $my_package_info['level_name'] ?></span>
		</li>
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_value')?> : </span>
			<span>$<?= number_format($user_info['package_value'], 2) ?></span>
		</li>
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_electron_multiplier')?> : </span>
			<span><?= $user_info['electron_multiple'] ?></span>
		</li>
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_bonus_electron')?> : </span>
			<span><?= number_format($user_info['electronic_number'], 2) ?></span>
		</li>
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'package_froze_electron')?> : </span>
			<span><?= number_format($user_info['froze_electronic_number'], 2) ?></span>
		</li>
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14 f-mt10">
			<p class="fc-f5ce7f"><?= Yii::t('app', 'package_description')?> : </p>
			<p class="f-mt5"><?= empty($my_package_info['package_description']) ? '/' : $my_package_info['package_description'] ?></p>
		</li>
		<li class="bg-bd0a2e f-p10 bordtot-890625 f-fs14 f-mt10">
			<p class="fc-f5ce7f"><?= Yii::t('app', 'package_business')?> : </p>
			<p class="f-mt5"><?php 
			$busiess = [];
			if (!empty($my_package_info['daily_dividend_check'])){$busiess[] = Yii::t('app', 'commission_daily_dividend');}
			if (!empty($my_package_info['task_benefit_check'])){$busiess[] = Yii::t('app', 'commission_task_benefit');}
			if (!empty($my_package_info['direct_reward_check'])){$busiess[] = Yii::t('app', 'commission_direct_reward');}
			if (!empty($my_package_info['development_reward_check'])){$busiess[] = Yii::t('app', 'commission_development_reward');}
			if (!empty($my_package_info['point_award_check'])){$busiess[] = Yii::t('app', 'commission_point_award');}
			echo implode('、', $busiess);
			?></p>
		</li>
	</ul>
	<!--底部开始-->
	<div class="bottom_div_h"></div>
	<div class="bottom_div">
		<div class="f-tc limit-size clearfix">
			<a href="<?= Url::toRoute('upgrade') ?>" class="f-w33 f-fl btn btn_yellow f-dib fc-333 f-fwb f-fs16"><?= Yii::t('app', 'package_upgrade')?></a>
			<a href="<?= Url::toRoute('recharge') ?>" class="f-w33 f-fl btn btn_yellowY f-dib fc-333 f-fwb f-fs16"><?= Yii::t('app', 'recharge')?></a>
			<a href="<?= Url::toRoute('recast') ?>" class="f-w33 f-fl btn btn_yellowD f-dib fc-333 f-fwb f-fs16"><?= Yii::t('app', 'recast')?></a>
		</div>
	</div>
	<!--底部开始-->
    <?php } else { ?>
    <!--还没购买配套时候开始-->
    <div class="bg-f8d788 f-pt20 f-pb20 f-tc f-fs15 fc-960e2a f-fwb hide">
		<p class="f-pt20 f-lh18"><?= Yii::t('app', 'package_task_no_package') ?></p>
        <a href="<?= Yii::$app->homeUrl ?>" class="btn btn_red fc-fff f-pt5 f-pb5 f-pl15 f-pr15 f-dib f-mt15 f-br5 f-mb30"><?= Yii::t('app', 'package_buy') ?></a>
    </div>
    <!--还没购买配套时候结束-->
	<?php } ?>
</div>
<?php $this->endBlock() ?>
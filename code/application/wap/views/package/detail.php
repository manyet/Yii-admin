<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'top_package');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::home() ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'top_package')?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size f-pb20">
	<div><img src="<?= $package_image_path?>" onerror="this.src='<?= Yii::getAlias('@img') ?>/noimg.jpg'" class="f-w100"/></div>

    <div class="bg-bd0a2e f-pl10 f-pr10 f-pb10 f-fs14">
		<p class="f-pt10">
			<span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'package_name')?> : </span>
			<span class="fc-fff"><?= $package_name?></span>
        </p>
        <p class="f-pt10">
			<span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'package_price')?> : </span>
            <span class="fc-fff">$<?= number_format($package_value, 2) ?></span>
        </p>
        <p class="f-pt10">
			<span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'package_rank')?> : </span>
            <span class="fc-fff"><?= $level_name?></span>
        </p>
        <p class="f-pt10">
			<span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'package_electron_multiple')?> : </span>
            <span class="fc-fff"><?= $electron_multiple?></span>
        </p>
        <p class="f-pt10">
			<span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'package_business')?> : </span>
            <span class="fc-fff f-lh18">
				<?php 
					$busiess = [];
					if (!empty($daily_dividend_check)){$busiess[] = Yii::t('app', 'commission_daily_dividend');}
					if (!empty($task_benefit_check)){$busiess[] = Yii::t('app', 'commission_task_benefit');}
					if (!empty($direct_reward_check)){$busiess[] = Yii::t('app', 'commission_direct_reward');}
					if (!empty($development_reward_check)){$busiess[] = Yii::t('app', 'commission_development_reward');}
					if (!empty($point_award_check)){$busiess[] = Yii::t('app', 'commission_point_award');}
					echo implode('、', $busiess);
				?>
			</span>
        </p>
        <p class="f-pt10">
			<span class="fc-f5ce7f f-fwb"><?= Yii::t('app', 'package_description')?> : </span>
            <span class="fc-fff f-lh18"><?= $package_description?></span>
        </p>
    </div>
	
    <!--图文展示开始-->
    <div class="fc-fff bg-bd0a2e f-mt15 f-bs f-p10 casino_detail"><?= $package_detail ?></div>
    <!--图文展示开始-->
</div>
<?php $this->endBlock() ?>

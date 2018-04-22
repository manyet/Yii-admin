<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'invest');
?>

<?php $this->beginBlock('container') ?>
<?php if (!empty($project)) { ?>
<div class="limit-size bg-bd0a2e limit-height">
    <div class="fc-fff f-fs14 bg-c32545 f-p10 f-tc">
    	<p class="f-fs16"><?=Yii::t('app','investment_total')?></p>
        <div class="f-fs22 f-mt10"><?= number_format($total, 2) ?></div>
        <table class="f-w100 f-mt20 invest_table">
        	<tbody>
            	<td class="f-w50 f-bs">
                	<a href="<?= yii\helpers\Url::toRoute('dividend') ?>" class="f-db fc-fff f-fs14">
                		<h3><?=Yii::t('app','investment_Personal')?> <span class="fc-f5ce7f">››</span></h3>
                    	<div class="f-fs18 f-mt5"><?= number_format($user_info['total_dividend_reward'], 2) ?></div>
                    </a>
                </td>
                <td class="f-w50 f-bs">
                	<a href="<?= yii\helpers\Url::toRoute('detail') ?>" class="f-db fc-fff f-fs14">
                        <h3><?=Yii::t('app','withdraw_cash_withdrawals')?> <span class="fc-f5ce7f">››</span></h3>
                        <div class="f-fs18 f-mt5"><?= number_format($user_info['company_dividend'], 2) ?></div>
                    </a>
                </td>
            </tbody>
        </table>
    </div>
    
    <div class="f-pb10 bg-bd0a2e">
        <div class="f-mt20 f-pl10 f-pr10 fc-fff f-fs16">
        	<h2 class="fc-f5ce7f f-fwb f-fs16"><?=Yii::t('app','investment_projects')?></h2>
            <p class="f-lh18 f-mt5">
            	<span class="fc-f5ce7f"><?=Yii::t('app','investment_projects_name')?> :</span>
                <span><?= $project['name'] ?></span>
            </p>
            <p class="f-lh18 f-mt5">
            	<span class="fc-f5ce7f"><?= Yii::t('app','investment_start_time')?> :</span>
                <span><?= $project['start_date'] ?></span>
            </p>
            <p class="f-lh18 f-mt5 fc-f5ce7f"><?=Yii::t('app','investment_introduction')?> :</p>
            <p class="f-lh18 f-mt5"><?= parseTextareaContent($project['description']) ?></p>
            <div class="f-mt10"><img src="<?= $project['img_path'] ?>" onerror="this.src='<?= Yii::getAlias('@img') ?>/noimg.jpg'" class="f-w100"/></div>
        </div>
        
    </div>

   <div style="height:8rem;"></div><!--底部导航撑开高度--需有-->
</div>
<?php } else { ?>
<div class="limit-size">
	<div class="f-tc f-mt30 f-fs15 fc-f5ce7f">
    	<img src="<?= Yii::getAlias('@img') ?>/nothings.png" class="f-w50"/>
        <p class="f-mt15"><?= Yii::t('app', 'no_data') ?></p>
    </div>
</div>
<?php } ?>
<?= $this->render('//layouts/footer', ['selected' => 'invest']) ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>
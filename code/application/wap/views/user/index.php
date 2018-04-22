<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'my');
?>

<?php $this->beginBlock('header') ?>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'my') ?></h2>
<a href="<?= Url::toRoute('notice/index') ?>" class="my_news"></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<a href="<?= Url::toRoute('user/basic-info') ?>" class="f-db my_top">
        <table class="f-w100 bg-bd0a2e my_top_in">
            <tbody>
                <tr>
                    <td class="my_top_img"><span class="f-br50 bg-c32545"><img src="<?= Yii::getAlias('@img') ?>/my_user.png"/></span></td>
                    <td class="f-pl15"> 
                        <div class="">
                            <span class="fc-f5ce7f f-fs16 f-fwb"><?= $uname ?></span>
                            <span class="bg-f8d788 fc-960e2a f-fs15 f-fwb f-pl10 f-pr10 f-lh22 f-ml10 f-br5"><?= getUserIdentity($identity) ?></span>
                        </div>
                        <p class="f-fs15 fc-fff f-lh20 ">
							<span><?= Yii::t('app', 'left_package') ?> : </span>
                            <span><?= $level_name ?></span>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </a>
    <div class="my_top_h"></div><!--头部高度撑开-->
    
    <h2 class="f-fs16 fc-fff f-pl10 f-pr10 f-pt15 f-pb15"><?=Yii::t('app','mes_wallet')?></h2>
    <ul class="bg-bd0a2e my_ul">
    	<li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('company') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my01.png"/>
                <span><?= Yii::t('app', 'wallet_company_score') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('cash') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my02.png"/>
                <span><?= Yii::t('app', 'wallet_cash_score') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('entertainment') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my03.png"/>
                <span><?= Yii::t('app', 'wallet_entertainment_score') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('dividend') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my04.png"/>
                <span><?= Yii::t('app', 'wallet_company_bonus') ?></span>
            </a>
        </li>
    </ul>
    
    <h2 class="f-fs16 fc-fff f-pl10 f-pr10 f-pt15 f-pb15"><?=Yii::t('app','wap_package_business')?></h2>
    <ul class="bg-bd0a2e my_ul">
    	<li class="f-pl10 f-pr10">
        	<a href="<?=Url::toRoute('daily-commission')?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my05.png"/>
                <span><?= Yii::t('app', 'commission_daily_dividend') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?=Url::toRoute('task-commission')?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my06.png"/>
                <span><?= Yii::t('app', 'commission_task_benefit') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?=Url::toRoute('promote-commission')?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my07.png"/>
                <span><?= Yii::t('app', 'commission_direct_reward') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?=Url::toRoute('develop-commission')?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my08.png"/>
                <span><?= Yii::t('app', 'commission_development_reward') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?=Url::toRoute('point-commission')?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my09.png"/>
                <span><?= Yii::t('app', 'commission_point_award') ?></span>
            </a>
        </li>
    </ul>
    
    <h2 class="f-fs16 fc-fff f-pl10 f-pr10 f-pt15 f-pb15"><?=Yii::t('app','more_info')?></h2>
    <ul class="bg-bd0a2e my_ul">
    	<li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('package/my') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my10.png"/>
                <span><?= Yii::t('app', 'package_my_package') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('record') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my14.png"/>
                <span><?= Yii::t('app', 'withdraw_record') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('relation/direct') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my11.png"/>
                <span><?=Yii::t('app','promotion_list')?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('faq/index') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my12.png"/>
                <span><?= Yii::t('app', 'top_faq') ?></span>
            </a>
        </li>
        <li class="f-pl10 f-pr10">
        	<a href="<?= Url::toRoute('faq/about') ?>" class="f-db fc-fff f-fs15 bordtot-890625 f-pt10 f-pb10">
                <img src="<?= Yii::getAlias('@img') ?>/my13.png"/>
                <span><?= Yii::t('app', 'about') ?></span>
            </a>
        </li>
    </ul>

    <div class="f-m15">
        <a href="<?= Url::toRoute('logout') ?>" class="btn2 bg-c32545 f-w100 f-db f-tc f-fs16 f-pt10 f-pb10 fc-fff f-fwb f-br5"><?= Yii::t('app', 'top_logout') ?></a>
    </div>

	<div style="height:8rem;"></div><!--底部导航撑开高度--需有-->
</div>
<?= $this->render('//layouts/footer', ['selected' => 'my']) ?>
<?php $this->endBlock() ?>
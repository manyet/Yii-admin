<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_security_information');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'user_about_me')?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-f8d788 limit-height">

	<!--头部tal开始-->
	<div class="data_top">
        <ul class="limit-size bg-fdedc9 clearfix">
            <li class="f-w50 f-fl f-tc"><a href="<?= Url::toRoute('user/basic-info')?>" class="f-db f-fs15 fc-333 f-fwb"><?= Yii::t('app', 'user_basic_data')?></a></li>
            <li class="f-w50 f-fl f-tc sel"><a class="f-db f-fs15 fc-333 f-fwb"><?= Yii::t('app', 'user_security_information')?></a></li>
        </ul>
    </div>
   <div style="height:4rem;"></div>
    <!--头部tal结束-->
    
	<div class="bg-f8d788 f-pl10 f-pr10 f-pt10 f-pb20">
        <div class="bg-bd0a2e f-pl10 f-pr10 f-mt10 f-fs15 fc-fff">
        	<ul class="data_ul">
            	<li>
					<a href="<?= Url::toRoute('bind-email')?>" class="f-db f-fs15 fc-fff f-pt15 f-pb15">
                    	<span class="fc-f5ce7f"><?= Yii::t('app', 'user_registered_mailbox')?> :</span>
                        <span>
							<?php 
								if (!empty($user_info['email'])) {
									echo getHiddenEmail($user_info['email']);
								}
							?>
						</span>
                    </a>
                </li>
                <li>
                	<a href="<?= Url::toRoute('update-pwd')?>" class="f-db f-fs15 fc-fff f-pt15 f-pb15">
                    	<span class="fc-f5ce7f"><?= Yii::t('app', 'user_login_password')?> :</span>
                        <span><?= empty($user_info['pwd']) ? Yii::t('app', 'user_password_rule') : '********';?></span>
                    </a>
                </li>
                <li>
                	<a href="<?= empty($user_info['pay_pwd']) ? Url::toRoute('save-pay-pwd') : Url::toRoute('update-pay-pwd')?>" class="f-db f-fs15 fc-fff f-pt15 f-pb15">
                    	<span class="fc-f5ce7f"><?= Yii::t('app', 'user_pay_password')?> :</span>
                        <span><?= empty($user_info['pay_pwd']) ? Yii::t('app', 'user_no_pay_pwd') : '********';?></span>
                    </a>
                </li>
                <li>
                	<a href="<?= empty($user_info['bank_card']) ? Url::toRoute('save-bank-card') : Url::toRoute('bind-bank-card')?>" class="f-db f-fs15 fc-fff f-pt15 f-pb15">
                    	<span class="fc-f5ce7f"><?= Yii::t('app', 'user_bank_card')?> :</span>
                        <span>
							<?php
								if (!empty($user_info['bank_card'])) {
									echo substr($user_info['bank_card'], 0, 4) . ' **** **** ' . substr($user_info['bank_card'], -4, 4);
								} else {
									echo Yii::t('app', 'user_no_bank_card');
								}
							?>
						</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>
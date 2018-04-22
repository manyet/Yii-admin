<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_basic_data');
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
            <li class="f-w50 f-fl f-tc sel"><a class="f-db f-fs15 fc-333 f-fwb"><?= Yii::t('app', 'user_basic_data')?></a></li>
            <li class="f-w50 f-fl f-tc"><a href="<?= Url::toRoute('user/security-info')?>" class="f-db f-fs15 fc-333 f-fwb"><?= Yii::t('app', 'user_security_information')?></a></li>
        </ul>
    </div>
    <div style="height:4rem;"></div>
    <!--头部tal结束-->

	<div class="bg-f8d788 f-pl10 f-pr10 f-pt10 f-pb20">
		<form name="info" data-ajax data-validate action="<?= Url::toRoute('save-info') ?>" onsubmit="return false" method="post">
        <div class="bg-bd0a2e f-pl10 f-pr10 f-pt10 f-pb20 f-mt10 f-fs15 fc-fff">
			<div class="f-mt10 clearfix">
				<span class="fc-f5ce7f"><?= Yii::t('app', 'username')?> : </span>
                <span class="f-fr"><?= $user_info['uname'] ?></span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f"><?= Yii::t('app', 'left_identity')?> : </span>
                <span class="f-fr"><?= getUserIdentity($user_info['identity']) ?></span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f"><?= Yii::t('app', 'invitation_code')?> : </span>
                <span class="f-fr"><?= $user_info['invite_code'] ?></span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f"><?= Yii::t('app', 'user_nickname')?> : </span>
                <span class="f-fr"><?= $user_info['nickname'] ?></span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f"><?= Yii::t('app', 'realname')?> : </span>
                <span class="f-fr"><?= $user_info['realname'] ?></span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f"><?= Yii::t('app', 'user_gender')?> : </span>
                <span class="f-ml20 f-fr">
                    <input id="g-2" type="radio" name="gender" class="slecte_input" value="2" <?php if ($user_info['gender'] == 2) { echo ' checked'; } ?> />
                    <label for="g-2"><?= Yii::t('app', 'user_female')?></label>
                </span>
				<span class="f-ml20 f-fr">
                    <input id="g-1" type="radio" name="gender" class="slecte_input" value="1" <?php if ($user_info['gender'] == 1) { echo ' checked'; } ?> />
                    <label for="g-1"><?= Yii::t('app', 'user_male')?></label>
                </span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f f-pt5 f-dib"><?= Yii::t('app', 'user_birthday')?> : </span>
                <span class="f-w60 f-dib f-fr">
                    <input type="text" class="f-w100 bg-fff bd-yellow f-fs15 f-pt5 f-pb5 f-pl5 f-bs" value="<?= $user_info['birthday'] ?>" readonly name="birthday" id="appDate" placeholder="<?= Yii::t('app', 'user_birthday_tip')?>" required /> 
                </span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f f-pt5 f-dib"><?= Yii::t('app', 'user_phone')?> : </span>
                <span class="f-w70 f-dib f-fr">
                    <input type="text" class="f-w100 bg-fff bd-yellow f-fs15 f-pt5 f-pb5 f-pl5 f-bs" name="mobile" value="<?= $user_info['mobile'] ?>" placeholder="<?= Yii::t('app', 'user_phone_tip')?>" required /> 
                </span>
            </div>
            <div class="f-mt10 clearfix">
				<span class="fc-f5ce7f f-pt5 f-dib"><?= Yii::t('app', 'user_superior_code')?> : </span>
                <span class="f-w35 f-dib f-fr f-tr">
					<?php
					if (empty($user_info['parent_id'])) {
						if ($has_lower) {
					?>
					<span class="f-pt5 f-dib"><?= Yii::t('app', 'user_condition_not_satisfy')?></span>
					<?php } else { ?>
					<input type="text" name="promoter_invite_code" class="f-w100 bg-fff bd-yellow f-fs15 f-pt5 f-pb5 f-pl5 f-bs" placeholder="<?= Yii::t('app', 'invitation_code')?>" value="<?= $user_info['promoter_invite_code'] ?>" />
					<?php
						}
					} else {
					?>
					<span class="f-pt5 f-dib"><?= $user_info['promoter_invite_code'] ?></span>
					<?php } ?>
                </span>
            </div>
            <div class="f-mt15 f-mb10">
                <button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 save_btn"><?= Yii::t('app', 'user_save')?></button>
            </div>
		</form>
        </div>
    </div>
</div>

<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@css') ?>/animate.min.css">
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/mobiscroll/mobiscroll_002.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/mobiscroll/mobiscroll_004.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@css') ?>/mobiscroll_002.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@css') ?>/mobiscroll.css">
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/mobiscroll/mobiscroll_003.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/mobiscroll/mobiscroll_005.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/mobiscroll/mobiscroll.js"></script>
<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@css') ?>/mobiscroll_003.css">
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/data.js"></script>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<?php $this->endBlock() ?>
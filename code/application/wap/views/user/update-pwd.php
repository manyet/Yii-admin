<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_modify_login_pwd');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/security-info') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'user_modify_login_pwd')?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<!--内容开始-->
<div class="limit-size bg-bd0a2e limit-height">
	<form name="pwd" data-ajax data-validate action="<?= \yii\helpers\Url::toRoute('update-pwd') ?>" onsubmit="return false" method="post">
	<div class="f-p10 bordtot-890625">
		<ul>
			<li class="f-mt5 f-pr">
				<input type="password" title="<?= Yii::t('app', 'user_old_login_pwd')?>" required name="opwd" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'user_old_login_pwd')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="password" title="<?= Yii::t('app', 'user_password_rule')?>" pattern="^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,}$" required name="pwd" id="pwd" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'password') ?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="password" title="<?= Yii::t('app', 'user_pwd_reset')?>" required name="rpwd" equalTo="#pwd" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" placeholder="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'confirm_password')?>"/>
			</li>
		</ul>
		<p class="ff-mt15 fc-d5d5d5 f-mt10 f-fs15 f-lh18">*<?= Yii::t('app', 'user_password_rule')?></p>
		<div class="f-mt15">
			<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 reset_btn"><?= Yii::t('app', 'user_confirm_modify')?></button>
		</div>
	</div>
	</form>	
</div>
<!--内容结束-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript">
$(function(){
	var $form = $(pwd).on('requestComplete', function(e, d){
		if (d.status === 1) {
			msg.toast(d.info, 2000, function(){
				location.href = d.url;
			});
		} else {
			msg.toast(d.info);
		}
	});
})
</script>
<?php $this->endBlock() ?>
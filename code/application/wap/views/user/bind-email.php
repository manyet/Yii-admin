<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'user_bind_mailbox');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/security-info') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'user_bind_mailbox')?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
	<form id="email" name="email" data-ajax data-validate action="<?= \yii\helpers\Url::toRoute('bind-email') ?>" onsubmit="return false" method="post">
	<div class="f-p10 bordtot-890625">
		<ul>
			<li class="f-mt5 f-pr">
				<input type="text" name="old_email" pattern="email" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" required title="<?= Yii::t('app', 'emial') . ' ' . Yii::t('app', 'format_error') ?>" placeholder="<?= Yii::t('app', 'user_current_mailbox')?>"/>
			</li>
			<li class="f-mt15 f-pr">
				<input type="text" name="new_email" pattern="email" class="f-w100 bg-fff f-fs15 bordb-e6e6e6 f-pl5 f-ptb8 f-bs" required title="<?= Yii::t('app', 'emial') . ' ' . Yii::t('app', 'format_error') ?>" placeholder="<?= Yii::t('app', 'user_new_mailbox')?>"/>
			</li>
		</ul>
		<p class="ff-mt15 fc-d5d5d5 f-mt10 f-fs15 f-lh18">*<?= Yii::t('app', 'user_receive_emails')?></p>
		<div class="f-mt15">
			<button class="btn btn_yellow f-w100 f-fs16 f-pt10 f-pb10 fc-333 f-fwb f-br5 email_next"><?= Yii::t('app', 'user_next')?></button>
		</div>
	</div>
	</form>	
</div>
<!--内容结束-->

<!--下一步弹窗开始-->
<div class="pop_bg hide next_pop">
	<div class="pop_in bg-fff">
		<p class="f-fs15 fc-333 f-pt15 f-pl10 f-pr10 f-fwb"><?= Yii::t('app', 'user_mailbox_title')?></p>
        <p class="f-fs15 fc-960e2a f-pl10 f-pr10 f-fwb f-mt10" id="send-email"></p>
        <p class="f-fs12 fc-666 f-pt15 f-pl10 f-pr10">* <?= Yii::t('app', 'user_mailbox_operation')?></p>
        <div class="f-mt15 f-tc f-mb20">
            <button class="btn2 btn_red f-fs16 f-ptb8 f-pl20 f-pr20 fc-fff f-fwb f-br5 ok_btn"><?= Yii::t('app', 'user_mailbox_well')?></button>
        </div>
    </div>
</div>
<!--下一步弹窗结束-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.validate.min.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript">
$(function(){
	var $form = $(email).on('requestComplete', function(e, d){
		if (d.status === 1) {
			$('#send-email').html(d.info);
			$('.next_pop').removeClass('hide');
			poplation();
		} else {
			msg.toast(d.info);
		}
	});
		
	//点击好的
	$('.ok_btn').click(function(e) {
		$('.next_pop').addClass('hide');
		location.href = "<?= \yii\helpers\Url::toRoute('security-info') ?>";
	});
	
})
</script>
<?php $this->endBlock() ?>
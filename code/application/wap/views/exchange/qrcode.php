<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'wap_exchange');
?>
<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'wap_exchange') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size bg-bd0a2e limit-height">
<div class="f-br5 f-pl15 f-pr15 f-bs bordtot-890625 exma_div">
    <div class="f-w80 f-m0a f-tc f-br5 bg-fff">
		<div id="output" style="position: relative">
			<div class="page_load" id="loading" style="position: absolute;">
				<div class="page_load_img" style="background-color: #960e2a"></div>
			</div>
		</div>
        <p class="f-fs22 f-fwb fc-000 f-tc f-mt15">$<?= number_format($amount, 2) ?></p>
    </div>
</div>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('head') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/public.js"></script>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script type="text/javascript" src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script>
var $loading = $('#loading'), $output = $('#output'), width = $output.width() * 0.8, amount = <?= $amount ?>, remark = "<?= $remark ?>", code = "";
$output.height(width);
function createQrcode(amount, remark){
	$.http.post('<?= Url::toRoute('generate') ?>', {amount: amount, remark: remark, code: code}, {
		before: function(){
			$loading.fadeIn();
		},
		after: function(){
			$loading.hide();
		},
		success: function(d){
			if (d.status === 1) {
				code = d.code;
				$output.find('canvas').remove();
				$output.qrcode({width:width,height:width,correctLevel:0,text:d.url});
				var intervalId = setInterval(function() {
					$.http.post('<?= Url::toRoute('check') ?>', {code: d.code}, {
						before: null,
						after: null,
						success: function(data){
							if (data.status === 1) {
								clearInterval(intervalId);
								msg.alert("<?= Yii::t('app', 'exchange_success') ?>", function(){
									location.href = "<?= Url::toRoute('record') ?>";
								});
							}
						}
					});
				}, 5000);
			} else {
				msg.toast(d.info, 2000, function() {
					if (d.url) location.href = d.url;
				});
			}
		}
	});
}
setTimeout(function(){
	createQrcode(amount, remark);
}, <?= Yii::$app->params['qrcodeExpire'] * 1000 ?>);
createQrcode(amount, remark);
</script>
<?php $this->endBlock() ?>

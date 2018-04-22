<?php
$this->title = $msgTitle;
$this->beginBlock('container')
?>
<div class="header_h"></div>
<div class="limit-size">
	<div class="f-tc f-mt30 lost_div">
    	<img src="<?= Yii::getAlias('@img') ?>/noimg.jpg"/>
        <p class="f-fs18 fc-fff f-mt15"><?= $message ?></p>
		<p class="f-fs14 fc-999 f-mt5"><?= Yii::t('app', 'wait_for_jump', ['second' => '<span id="wait" class="fc-f40">' . $waitSecond . '</span>', 'jump' => '<a id="href" class="fc-0e6a99" href="' . $jumpUrl . '">' . Yii::t('app', 'jump') . '</a>']) ?></p>
    </div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
<?php $this->endBlock() ?>
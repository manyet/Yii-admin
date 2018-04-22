<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'top_home');
?>
<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<?php if (!empty($carousel)) { ?>
	<!--轮播图开始-->
    <div class="swiper-container swiper-container1">
        <div class="swiper-wrapper">
			<?php
			foreach ($carousel as $one) {
			?>
            <div class="swiper-slide"><img src="<?= $one['wap_Picture'] ?>" class="f-w100"/></div>
			<?php
			}
			?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <!--轮播图结束-->
	<?php } ?>

	<?php if (!empty($features)) { ?>
    <!--规则开始-->
    <ul class="bg-bd0a2e f-pl10 f-pr10 f-pt10 index_rule">
		<?php
		foreach ($features as $one) {
		?>
    	<li>
			<a href="<?= Url::toRoute(['detail', 'id' => $one['id']]) ?>" class="f-db fc-fff f-fs16 f-toe1"><?= useCommonLanguage() ? $one['e_title'] : $one['title'] ?></a>
        </li>
		<?php
		}
		?>
    </ul>
    <!--规则结束-->
	<?php } ?>

	<!--配套开始-->
    <div class="bg-bd0a2e f-pb10">
        <h2 class="f-fs15 f-fwb fc-fff f-pt15 f-pb5 f-pl10 f-pr10">HOT PACKAGE</h2>
        <div class="swiper-container swiper-container2 bg-bd0a2e index_package f-p10">
            <div class="swiper-wrapper">
				<?php
				if (isLogin()) {
					$info = \common\services\UserService::getUserInfo(getUserId(), 'package_value');
					$package_value = $info['package_value'];
				} else {
					$package_value = 0;
				}
				foreach ($packages as $one) {
				?>
                <div class="swiper-slide">
                    <a href="<?= Url::toRoute(['package/detail', 'id' => $one['id']]) ?>" class="fc-fff f-fs14">
                        <div class="index_pac_img"><img src="<?=$one['package_image_path'] ?>" onerror='this.src="<?= Yii::getAlias('@img') ?>/noimg.jpg"'/></div>
                        <h2 class="f-toe1 f-lh18 f-mt5 f-tc"><?= $one['package_name'] ?></h2>
                        <p class="f-mt5 f-tc">$<?= number_format($one['package_value'], 2) ?></p>
                    </a>
					<button onclick="location.href='<?= Url::toRoute(['package/buy', 'id' => $one['id']]) ?>'"<?php if ($package_value >= $one['package_value']) { ?> disabled<?php } ?> class="btn f-db f-w100 f-pt5 f-pb5 f-fs16 f-mt10 fc-fff"><?=Yii::t('app','package_buy')?></button>
                </div>
				<?php } ?>
            </div>
        </div>
    </div>
    <!--casion开始-->
    <?php if ($open['C']==1){ ?>
    <div class=" f-pb10">
        <h2 class="f-fs15 f-fwb fc-fff f-pt15 f-pb15 f-pl10 f-pr10">HOT CASINO</h2>
        <ul class="casino_ul index_casino">
            <li class="bg-19181d">
                <a href="<?=$AdvertisingC['advertising_Path1']?>" class="f-db f-pr">
                    <span class="casino_img"><img src="<?=$AdvertisingC['advertising_Picture1']?>" onerror='this.src="<?= Yii::getAlias('@img') ?>/noimg.jpg"'/></span>
                    <span class="casino_ranking"></span>
                    <h2 class="f-pr f-pl25 f-pr25 f-mr5 f-fs15 fc-f5ce7f">
                        <span class="casino_flag"><img src="<?=$AdvertisingC['flag_Picture1']?>"/></span>
                        <span class="f-fwb"><?=$AdvertisingC['casino_name1']?></span>
                    </h2>
                    <div class="f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_exchange') ?> : </span>
                        <span><?=number_format($AdvertisingC['price1'], 2)?></span>
                    </div>
                    <p class="f-lh18 f-mt5 f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_player') ?> : </span>
                        <span><?=number_format($AdvertisingC['number1'], 0)?></span>
                    </p>
                </a>
            </li>
            <li class="bg-19181d">
                <a href="<?=$AdvertisingC['advertising_Path2']?>" class="f-db f-pr">
                    <span class="casino_img"><img src="<?=$AdvertisingC['advertising_Picture2']?>" onerror='this.src="<?= Yii::getAlias('@img') ?>/noimg.jpg"'/></span>
                    <span class="casino_ranking"></span>
                    <h2 class="f-pr f-pl25 f-pr25 f-mr5 f-fs15 fc-f5ce7f">
                        <span class="casino_flag"><img src="<?=$AdvertisingC['flag_Picture2']?>"/></span>
                        <span class="f-fwb"><?=$AdvertisingC['casino_name2']?></span>
                    </h2>
                    <div class="f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_exchange') ?> : </span>
                        <span><?=number_format($AdvertisingC['price2'], 2)?></span>
                    </div>
                    <p class="f-lh18 f-mt5 f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_player') ?> : </span>
                        <span><?=number_format($AdvertisingC['number2'], 0)?></span>
                    </p>
                </a>
            </li>
            <li class="bg-19181d">
                <a href="<?=$AdvertisingC['advertising_Path3']?>" class="f-db f-pr">
                    <span class="casino_img"><img src="<?=$AdvertisingC['advertising_Picture3']?>" onerror='this.src="<?= Yii::getAlias('@img') ?>/noimg.jpg"'/></span>
                    <span class="casino_ranking"></span>
                    <h2 class="f-pr f-pl25 f-pr25 f-mr5 f-fs15 fc-f5ce7f">
                        <span class="casino_flag"><img src="<?=$AdvertisingC['flag_Picture3']?>"/></span>
                        <span class="f-fwb"><?=$AdvertisingC['casino_name3']?></span>
                    </h2>
                    <div class="f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_exchange') ?> : </span>
                        <span><?=number_format($AdvertisingC['price3'], 2)?></span>
                    </div>
                    <p class="f-lh18 f-mt5 f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_player') ?> : </span>
                        <span><?=number_format($AdvertisingC['number3'], 0)?></span>
                    </p>
                </a>
            </li>
            <li class="bg-19181d">
                <a href="<?=$AdvertisingC['advertising_Path4']?>" class="f-db f-pr">
                    <span class="casino_img"><img src="<?=$AdvertisingC['advertising_Picture4']?>" onerror='this.src="<?= Yii::getAlias('@img') ?>/noimg.jpg"'/></span>
                    <span class="casino_ranking"></span>
                    <h2 class="f-pr f-pl25 f-pr25 f-mr5 f-fs15 fc-f5ce7f">
                        <span class="casino_flag"><img src="<?=$AdvertisingC['flag_Picture1']?>"/></span>
                        <span class="f-fwb"><?=$AdvertisingC['casino_name4']?></span>
                    </h2>
                    <div class="f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_exchange') ?> : </span>
                        <span><?=number_format($AdvertisingC['price4'], 2)?></span>
                    </div>
                    <p class="f-lh18 f-mt5 f-mt5 fc-fff f-fs15">
                        <span class="fc-f5ce7f"><?= Yii::t('app', 'main_player') ?> : </span>
                        <span><?=number_format($AdvertisingC['number4'], 0)?></span>
                    </p>
                </a>
            </li>
       </ul>
    </div>
    <?php } ?>
	<div style="height:6rem;"></div><!--底部导航撑开高度--需有-->
</div>
<?= $this->render('//layouts/footer', ['selected' => 'home']) ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@css') ?>/swiper.css">
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/swiper-3.4.2.jquery.min.js"></script>
<script type="text/javascript">
//轮播图滑动
var mySwiper1 = new Swiper('.swiper-container1',{
	pagination : '.swiper-pagination',
	autoplay: 2000,
	loop : true,
})
//轮播图滑动

//左右滑动
var mySwiper2 = new Swiper('.swiper-container2', {
	//autoplay: 5000,//可选选项，自动滑动
	slidesPerView : 2.5,
	spaceBetween : 12,
})
//左右滑动

$(function(){
	//配套的图片控制
	var imgw = $('.index_package').find('.index_pac_img').width() + 10;
	$('.index_package').find('.index_pac_img').height(imgw);
});
</script>
<?php $this->endBlock() ?>
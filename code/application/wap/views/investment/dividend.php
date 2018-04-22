<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'personal_invest_record');
?>
<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'personal_invest_record') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
    <ul id="pullrefresh" class="bg-bd0a2e fc-fff f-fs14 f-lh15 list_ul"></ul>
    <!--没有内容开始-->
    <div id="no-more" class="f-tc f-mt30 f-fs15 fc-f5ce7f hide">
        <img src="<?= Yii::getAlias('@img') ?>/nothings.png" class="f-w50"/>
        <p class="f-mt15"><?= Yii::t('app', 'no_data') ?></p>
    </div>
    <!--没有内容结束-->
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/artTemplate/template-native.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/helper.js"></script>
<script id="tpl" type="text/html">
<%for(var i = 0; i < list.length; i++){%>
<li class="f-p10 bordtot-890625 hide">
	<div class="clearfix">
		<span class="fc-f5ce7f"><?= Yii::t('app', 'interest_amount')?> :</span>
		<span><%=moneyFormat(list[i]['value'])%></span>
		<span class="f-fr fc-f5ce7f"><%=list[i]['remark']%></span>
	</div>
	<div class="clearfix f-mt5">
		<span><span class="fc-f5ce7f"><?= Yii::t('app', 'interest_change')?> : </span> <span><%=moneyFormat(list[i]['balance'])%></span></span>
		<span class="f-fr"><%=dateFormat(list[i]['create_time']*1000,'yyyy-MM-dd hh:mm:ss')%></span>
	</div>
</li>
<%}%>
</script>
<script type="text/javascript">
var config = {
	container: '#pullrefresh',
	up: {
		callback: pullupRefresh
	}
};
var pullObj = new pullRefresh(config), $noMore = $('#no-more');

var count = 0, page = 1, rows = 10;

template.helper('dateFormat', helper.dateFormat);
template.helper('moneyFormat', helper.moneyFormat);

/**
 * 上拉加载具体业务实现
 */
function pullupRefresh(isRefresh) {
	$.http.get('<?= \yii\helpers\Url::toRoute('get-data') ?>', {page: page, rows: rows}, {
		before: function() {
			if (isRefresh) this.loading = msg.loading();
		},
		after: function() {
			isRefresh && msg.closeLoading(this.loading);
		},
		success: function(data){
			if (data.list && data.list.length) {
				count += data.list.length;
				if (isRefresh) {
					pullObj.$container.empty();
					pullObj.reset();
					$('html,body').animate({scrollTop: 0}, 600);
				}
				$noMore.hide();
				$(template('tpl', data)).appendTo(pullObj.$container).fadeIn();
				pullObj.endPullupToRefresh(count >= data.total);
				++page;
			} else {
				pullObj.endPullupToRefresh();
				$noMore.fadeIn();
				pullObj.$container.html('');
				pullObj.reset();
			}
		}
	});
}
pullupRefresh(true);
</script>
<?php $this->endBlock() ?>

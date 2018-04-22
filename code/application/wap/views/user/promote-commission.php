<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'commission_direct_reward');
?>
<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'commission_direct_reward') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">

	<div class="top_div">
		<div class="fc-fff f-fs14 bg-c32545 f-pt15 f-pb15 f-tc limit-size">
			<p class="f-fs16 f-mt5"><?=Yii::t('app','commission_cumulative_bonus')?></p>
			<div class="f-fs22 f-mt10 f-mb5"><?= number_format($user_info['total_direct_reward'], 2) ?></div>
		</div>
	</div>
	<div style="height:8.5rem;"></div>
	<ul id="pullrefresh" class="bg-bd0a2e fc-fff f-fs14 f-lh15 list_ul"></ul>
	<!--没有内容开始-->
	<div id="no-more" class="f-tc f-mt30 f-fs15 fc-f5ce7f hide">
		<img src="<?= Yii::getAlias('@img') ?>/nothings.png" class="f-w50 f-mt30"/>
		<p class="f-mt15"><?= Yii::t('app', 'no_data') ?></p>
	</div>
	<!--没有内容结束-->
</div>
<?php $this->endBlock() ?>
<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/artTemplate/template-native.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/helper.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script id="tpl" type="text/html">
<%for(var i = 0; i < list.length; i++){%>
<li class="f-p10 bordtot-890625 hide">
	<div class="clearfix f-pr list_div">
		<span class="fc-f5ce7f"><?=Yii::t('app','commission_reward_from')?> : </span>
		<span><%=list[i]['nickname']%>(<%=list[i]['uname']%>),$<%=moneyFormat(list[i]['achievement'], 2)%></span>
		<span class="list_time f-tr"><%=dateFormat(list[i]['create_time']* 1000,'yyyy-MM-dd')%></span>
	</div>
	<div class="clearfix f-mt5">
		<span><span class="fc-f5ce7f"><?=Yii::t('app','commission_reward_ratio')?> : </span> <span><%=moneyFormat(list[i]['percentage'], 2)%>%</span></span>
		<span class="f-fr fc-f5ce7f f-fs16">
			<%=moneyFormat(list[i]['commission'], 2)%>
		</span>
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
	$.http.get('<?= \yii\helpers\Url::toRoute('promote-commission-list') ?>', {page: page, rows: rows}, {
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
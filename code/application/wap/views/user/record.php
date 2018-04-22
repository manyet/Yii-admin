<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'withdraw_record');
?>
<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'withdraw_record') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<!--搜索开始-->
	<div class="casino_search">
		<div class="limit-size bg-f8d788">
			<form name="sform" class=" f-pl15 f-pr15 f-bs f-db">
			<select name="type" class="f-w100 f-fs15 fc-333 bordb-e6e6e6 bg-fff f-pl5 f-br5 f-bs">
					<option value="" ><?= Yii::t('app', 'withdraw_all_type')?></option>
					<option value="1" <?php if (\Yii::$app->request->get('type')==1){?>selected<?php }?> ><?= Yii::t('app', 'withdraw_all_cash')?></option>
					<option value="2" <?php if (\Yii::$app->request->get('type')==2){?>selected<?php }?>><?= Yii::t('app', 'withdraw_all_dividends')?></option>
			</select>
			</form>
		</div>
	</div>
	<div style="height:5.2rem;"></div>
	<!--搜索结束-->
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
		<span><% if(list[i]['withdrawal_type']==1){ %><?= Yii::t('app', 'withdraw_all_cash')?> <% }else{ %>
			<?= Yii::t('app', 'withdraw_all_dividends')?> <% } %></span>
		<span class="list_time f-tr"><%=dateFormat(list[i]['application_time']* 1000,'yyyy-MM-dd')%></span>
	</div>
	<div class="clearfix f-mt5">
		<span><span class="fc-f5ce7f"><%=list[i]['currency']%></span> <span><%=moneyFormat(list[i]['integral'], 2)%></span></span>
		<span class="f-fr fc-f5ce7f f-fs16">
		   <% if(list[i]['state']==0){ %>
			<?= Yii::t('app', 'withdraw_all_in')?> <% }else if(list[i]['state']==1){ %>
			<?= Yii::t('app', 'withdraw_all_posted')?> <% }else{ %>
			<?= Yii::t('app', 'withdraw_all_cancelled')?> <% } %>
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
	$.http.get('<?= \yii\helpers\Url::toRoute('record-list') ?>', {type:sform.type.value,page: page, rows: rows}, {
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
var $form = $(sform).submit(function(e){
	page = 1;
	count = 0;
	pullupRefresh(true);
}).find('select').change(function(){
    $form.submit();
});
</script>
<?php $this->endBlock() ?>
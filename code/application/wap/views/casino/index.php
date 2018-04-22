<?php
/* @var $this \yii\web\View */
$this->title = Yii::t('app', 'top_casino');
?>
<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<!--搜索开始-->
	<div class="casino_search">
		<div class="limit-size bg-f8d788 f-tc">
			<form name="sform">
				<input name="key" type="text" class="f-w60 f-ptb8 f-fs15 fc-333 bordb-e6e6e6 bg-fff f-pl5 f-br5 f-bs" placeholder="<?= Yii::t('app', 'casino_look_up') ?>"/>
				<button class="btn2 btn_red f-fs15 f-ptb8 f-pl10 f-pr10 fc-fff f-fwb f-br5 f-ml10"><?= Yii::t('app', 'search') ?></button>
			</form>
		</div>
	</div>
	<div style="height:5.2rem;"></div>
	<!--搜索结束-->

	<ul id="pullrefresh" class="casino_ul"></ul>
	<!--没有内容开始-->
	<div id="no-more" class="f-tc f-mt30 f-fs15 fc-f5ce7f hide">
		<img src="<?= Yii::getAlias('@img') ?>/nothings.png" class="f-w50 f-mt30"/>
		<p class="f-mt15"><?= Yii::t('app', 'no_data') ?></p>
	</div>
	<!--没有内容结束-->

	<div style="height:12rem;"></div><!--底部导航撑开高度--需有-->
</div>
<?= $this->render('//layouts/footer', ['selected' => 'casino']) ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script') ?>
<script src="<?= Yii::getAlias('@plug') ?>/artTemplate/template-native.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script src="<?= Yii::getAlias('@plug') ?>/jquery.scrollLoading-min.js"></script>
<script id="tpl" type="text/html">
<%for(var i = 0; i < list.length; i++){%>
<li class="bg-19181d hide">
	<a href="<?= \yii\helpers\Url::toRoute(['detail' ])?>?id=<%=list[i]['id']%>" class="f-db f-pr">
		<span class="casino_img"><img src="<?= Yii::getAlias('@img') ?>/noimg.jpg" data-url="<%=list[i]['casino_picture']%>"/></span>
		<h2 class="f-pr f-pl25 f-fs15 fc-f5ce7f">
            <% if(list[i]['flag_picture']!=NULL){ %>
			<span class="casino_flag"><img data-url="<%=list[i]['flag_picture']%>"/></span>
            <% } %>
            <?php if (useCommonLanguage()){ ?>
			<span class="f-fwb"><%= list[i]['e_casino_name']%></span>
            <?php }else{ ?>
                <span class="f-fwb"><%= list[i]['casino_name']%></span>
            <?php } ?>
		</h2>
		<div class="f-mt5 fc-fff f-fs15">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'casino_country') ?></span>
            <?php if (useCommonLanguage()){ ?>
			<span><%=list[i]['e_from']%></span>
            <?php }else{ ?>
            <span><%=list[i]['from']%></span>
            <?php } ?>
		</div>
		<p class="f-lh18 f-mt5 f-mt5 fc-fff f-fs15">
			<span class="fc-f5ce7f"><?= Yii::t('app', 'casino_entertainment') ?></span>
            <?php if (useCommonLanguage()){ ?>
                <span><%=list[i]['e_projects']%></span>
            <?php }else{ ?>
                <span><%=list[i]['projects']%></span>
            <?php } ?>
		</p>
	</a>
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
/**
 * 上拉加载具体业务实现
 */
function pullupRefresh(isRefresh) {
	$.http.get('<?= \yii\helpers\Url::toRoute('get-data') ?>', {key: sform.key.value, page: page, rows: rows}, {
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
				$(template('tpl', data)).appendTo(pullObj.$container).fadeIn().find('img').bindLazyload();
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
$(sform).submit(function(e){
	e.preventDefault();
	page = 1;
	count = 0;
	pullupRefresh(true);
});
</script>
<?php $this->endBlock() ?>
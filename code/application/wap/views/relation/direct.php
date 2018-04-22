<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;

$this->title = Yii::t('app', 'promotion_list');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::home() ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'promotion_list') ?></h2>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
	<!--搜索开始-->
    <div class="casino_search">
   	  <div class="limit-size bg-f8d788 f-tc">
		  <form name="sform">
        	<input name="kw" type="text" class="f-w70 f-ptb8 f-fs15 fc-333 bordb-e6e6e6 bg-fff f-pl5 f-br5 f-bs" placeholder="<?= Yii::t('app', 'please_enter') . ' ' . Yii::t('app', 'username') . ' / ' . Yii::t('app', 'nickname') ?>"/>
            <button class="btn2 btn_red f-fs15 f-ptb8 f-pl10 f-pr10 fc-fff f-fwb f-br5 f-ml10"><?= Yii::t('app', 'search') ?></button>
		  </form>
        </div>
    </div>
   <div style="height:5.2rem;"></div>
    <!--搜索结束-->

    <ul id="pullrefresh" class="bg-bd0a2e fc-fff f-fs14 f-lh15 list_ul"></ul>
    
    <!--搜索不到内容的时候开始-->
    <div class="f-fs15 f-tc fc-960e2a bg-fdedc9 f-pt15 f-pb15 hide"><?= Yii::t('app', 'no_data') ?></div>
    <!--搜索不到内容的时候结束-->
    
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
<script src="<?= Yii::getAlias('@js') ?>/helper.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/msg.js"></script>
<script src="<?= Yii::getAlias('@js') ?>/app.js"></script>
<script id="tpl" type="text/html">
<%for(var i = 0; i < list.length; i++){%>
<li class="f-p10 bordtot-890625 hide">
	<div class="clearfix f-pr list_div">
		<span class="fc-f5ce7f"><?=Yii::t('app','relation_nike_name')?> : </span>
		<span><%=list[i]['nickname']%></span>
		<span class="list_time f-tr"><%=dateFormat(list[i]['bind_time']*1000,'yyyy-MM-dd')%></span>
	</div>
	<div class="clearfix f-mt5">
		<span class="fc-f5ce7f"><?=Yii::t('app','username')?> : </span>
		<span><%=list[i]['uname']%></span>
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

/**
 * 上拉加载具体业务实现
 */
function pullupRefresh(isRefresh) {
	$.http.get('<?= \yii\helpers\Url::toRoute('get-data') ?>', {kw: sform.kw.value, page: page, rows: rows}, {
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
$(sform).submit(function(e){
	e.preventDefault();
	page = 1;
	count = 0;
	pullupRefresh(true);
});
</script>
<?php $this->endBlock() ?>
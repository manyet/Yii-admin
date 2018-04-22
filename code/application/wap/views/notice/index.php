<?php
/* @var $this \yii\web\View */
use yii\helpers\Url;
$this->title = Yii::t('app', 'notice_wap_notice');
?>

<?php $this->beginBlock('header') ?>
<a href="<?= Url::toRoute('user/index') ?>" class="back"></a>
<h2 class="f-fs16 fc-fff"><?= Yii::t('app', 'notice_wap_notice')?></h2>
<a id="read-all" class="f-fs15 fc-f5ce7f news_read"><?= Yii::t('app', 'notice_read_all')?></a>
<?php $this->endBlock() ?>

<?php $this->beginBlock('container') ?>
<div class="limit-size">
    <ul id="pullrefresh" class="f-pl10 f-pr10 news_ul">
		<!-- 消息列表 -->
    </ul>

    <!--没有内容开始-->
    <div id="no-data" class="f-tc f-mt30 f-fs15 fc-f5ce7f hide">
		<img src="<?= Yii::getAlias('@img') ?>/nothings.png" class="f-w50"/>
        <p class="f-mt15"><?= Yii::t('app', 'no_data')?></p>
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
<li <%if (list[i]['n_status'] != 1){ %> class="sel" <%}%>>
	<a href="<?= \yii\helpers\Url::toRoute(['detail', 'id' => '']) ?><%=list[i]['id']%>" class=" f-db f-pt10 ">
		<h2 class="f-fs14 fc-d5d5d5"><%=dateFormat(list[i]['create_time']* 1000,'yyyy-MM-dd hh:mm:ss')%></h2>
		<div class="f-mt5 f-p10">
			<h3 class="f-fs15 f-fwb"><%=list[i]['title']%></h3>
			<p class="f-toe2 f-lh15 f-fs14 f-mt5"><%=list[i]['content']%></p>
		</div>
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
var pullObj = new pullRefresh(config), $noMore = $('#no-more'), $noData = $('#no-data');

var count = 0, page = 1, rows = 10;

template.helper('dateFormat', helper.dateFormat);
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
				$noData.fadeIn();
				pullObj.$container.html('');
				pullObj.reset();
			}
		}
	});
}
pullupRefresh(true);

$('#read-all').on('click', function(){
	var unread = '<?= $unread?>';
	if (parseInt(unread) <= 0) {
		return;
	}
	$.http.get('<?= \yii\helpers\Url::toRoute('read-all') ?>', {}, function(d){
		if (d.status == 1) {
			//$('#pullrefresh').find('.sel').removeClass('sel');
			location.reload();
		} 
	});
});
</script>
<?php $this->endBlock() ?>
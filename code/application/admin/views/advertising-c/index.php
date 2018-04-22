<?php
use yii\helpers\Url;
$keyword = \Yii::$app->request->get('keyword');
?>
<?php $this->beginBlock('title') ?>
MESPC广告位C
<div style="position: relative;display: inline-block;">
	<input id="ad_is" style="position: absolute; top: -20px" class="switch switch-animbg"<?= $this->params['open']['open'] == 1 ? ' checked' : '' ?> type="checkbox">
</div>
<link rel="stylesheet" href="<?= get_css_url() ?>switch.css">
<script>
$("#ad_is").change(function (e) {
	var self = this;
	$.http.post('<?=\yii\helpers\Url::toRoute('open')?>', {open: this.checked ? 1 : 0}, function (d) {
		if (d.status === 1) {
			$.msg.success(d.info);
		} else {
			self.checked = !self.checked;
			$.msg.error(d.info);
		}
	});
});
function geRelease($val) {
    switch (parseInt($val)) {
        case 0:
            return '存档中';
        case 1:
            return '展示中';
    }
}
</script>
<?php $this->endBlock() ?>

<?php $this->beginBlock('search') ?>
<div class="callout callout-info">
	<h4>广告位描述</h4>
	<p>MESPC广告位C为娱乐场TOP4广告位，位于莫斯平台PC首页底部赌场TOP4榜单板块展示，可点击右侧‘位置图览’进行位置查看。固定广告位数4位， TOP1大图建议尺寸578 x 200，TOP2~TOP4小图建议尺寸170 x 155（建议每张图比例一样），支持格式JPG、PNG，可预览后再做发布处理。</p>
</div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<form class="form-inline" role="form"
	  action="<?= \yii\helpers\Url::toRoute($this->context->id . '/' . $this->context->action->id) ?>"
	  data-search >
	<div class="form-group">
		<div class="input-group input-group-sm">
			<input class="form-control" type="text" placeholder="广告组名称/广告组描述" name="keyword"
				   value="<?php if ($keyword != '') {
					   echo $keyword;
				   } ?>"/>
			<span class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-search"></i> 搜索</button></span>
		</div>
	</div>
	<div class="form-group pull-right">
		<button type="button" class="btn btn-sm btn-default" data-thumb="<?= get_img_url('advertising-c.jpeg') ?>" data-max-width="1000">位置图览</button>
		<?php if (checkAuth('advertising-c/add')) { ?>
		<button type="button" class="btn btn-sm btn-success" data-href="<?=\yii\helpers\Url::toRoute('advertising-c/add') ?>"><i class="fa fa-plus"></i>&nbsp;新增广告组</button>
		<?php } ?>
	</div>
</form>

<?= \admin\widgets\Table::widget([
//    'checkbox' => 'ids',//$.table.getChecked();拿到选中
	'columns' => array(
		array('field' => 'advertising_name', 'title' => '广告组名称'),
		array('field' => 'advertising_describe', 'title' => '广告组描述'),
		array('field' => 'create_time', 'title' => '创建时间', 'js' => 'showDate'),
		array('field' => 'open', 'title' => '状态','js'=>'geRelease'),
	),
	'operations' => array(
        array('key' => 'id', 'text' => '编辑', 'js' => 'getHrefButton', 'path' => 'advertising-c/add'),
        array('key' => 'open', 'js' => 'getReleaseButton', 'path' => 'advertising-c/release'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'advertising-c/del')
	),
	'list' => $list
]) ?>
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
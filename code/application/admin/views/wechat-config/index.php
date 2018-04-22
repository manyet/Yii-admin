<?php $this->beginBlock('title') ?>
公众号管理
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<!--<?php if (checkAuth('wechat-config/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-modal="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;添加公众号</button>
<?php } ?>-->
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function getWecahtType(k) {
	var types = <?= json_encode(common\services\WechatConfigService::getType()) ?>;
	return types[k] || '未知类型';
}
function getToken(id) {
	return '<a href="javascript:;" data-clipboard-text="'+id+'"><i class="fa fa-copy"></i> 复制</a>';
}
var frontUrl = '<?= Yii::$app->params['apiUrl'] ?>/wechat/handle/';
function getWechatUrl(id) {
	return '<a href="javascript:;" data-clipboard-text="'+frontUrl+id+'"><i class="fa fa-copy"></i> 复制</a>';
}
</script>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'name', 'title' => '名称'),
		array('field' => 'appid', 'title' => 'AppId'),
		array('field' => 'token', 'title' => '公众平台接口配置Token', 'js' => 'getToken'),
		array('field' => 'id', 'title' => '公众平台接口配置URL', 'js' => 'getWechatUrl'),
		array('field' => 'type', 'title' => '类型', 'js' => 'getWecahtType'),
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'getModalButton', 'path' => 'wechat-config/edit'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'wechat-config/del'),
	),
	'list' => $list
]) ?>
<script>
$('[data-clipboard-text],[data-clipboard-target]').createClipboard();
</script>
<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
	$this->beginBlock('footer');
	echo $pager;
	$this->endBlock();
}
?>
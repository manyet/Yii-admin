<?php $this->beginBlock('title') ?>
文章管理
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('wechat-article/add')) { ?>
<button type="button" class="btn btn-xs btn-success" data-href="<?=\yii\helpers\Url::toRoute('add')?>"><i class="fa fa-plus"></i>&nbsp;添加文章</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
var frontUrl = '<?= Yii::$app->params['frontUrl'] ?>/article/detail.html?id=';
function getArticleUrl(id) {
	return '<a style="border-right:1px solid #ccc;padding-right:5px;margin-right:5px;" href="javascript:;" data-clipboard-text="'+frontUrl+id+'"><i class="fa fa-copy"></i> 复制</a><a href="javascript:;" data-wechat-view="'+frontUrl+id+'"><i class="fa fa-eye"></i> 预览</a>';
}
</script>
<?= \admin\widgets\Table::widget([
	'columns' => array(
		array('field' => 'local_url', 'title' => '封面图片', 'js' => 'showThumb'),
		array('field' => 'title', 'title' => '文章标题', 'align' => 'left'),
		array('field' => 'author', 'title' => '发布作者'),
		array('field' => 'create_at', 'title' => '撰写时间'),
		array('field' => 'id', 'title' => '访问链接', 'js' => 'getArticleUrl'),
	),
	'operations'  => array(
		array('key' => 'id', 'text' => '编辑', 'js' => 'getHrefButton', 'path' => 'wechat-article/edit'),
		array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'wechat-article/del')
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
<?php /* @var $this \yii\web\View */ ?>
	<?php $this->beginBlock('title'); ?><a href="javascript:$.page.back();"><i class="fa fa-angle-left" style="width: 10px"></i></a> 多图文管理<?php $this->endBlock() ?>

<?php $this->beginBlock('content'); ?>
<div class="row">
<div class="col-md-3" style="width: 232px">
	<button type="button" onclick="saveArticles()" class="btn btn-default btn-flat btn-block">保存多图文</button>
	<ul id="wechat-list-view" class="wechat-list-view"><li class="text-center" style="padding: 30px 0">请搜索后添加图文</li></ul>
</div>
<script type="text/html" id="articles-tpl">
<%for(var i = 0; i < list.length; i++){%>
<li data-id="<%= list[i]['id'] %>">
	<div class="wechat-list-img handle" style="background-image: url(<%= list[i]['local_url'] %>)"></div>
	<div class="wechat-list-text handle"><%= list[i]['title'] %></div>
	<div class="clearfix"></div>
	<div class="text-center wechat-tools"><a data-del-article href="javascript:;"><i class="fa fa-trash-o"></i></a></div>
</li>
<%}%>
</script>
<script>
var $listView = $("#wechat-list-view");
require(['jquery-ui'], function(){
  $listView.sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999
  }).disableSelection();
});
</script>
<div class="col-md-4">
	<form id="search-article-form" role="form" action="<?= \yii\helpers\Url::toRoute('search') ?>" onsubmit="return false;">
		<div class="form-group">
			<div class="input-group input-group-sm">
				<input class="form-control" type="text" placeholder="文章标题/作者" name="kw" />
				<span class="input-group-btn">
				  <button class="btn btn-default">搜索</button>
				</span>
			</div>
		</div>
	</form>
	<ul class="products-list product-list-in-box" id="article-con"></ul>
</div>
<script type="text/html" id="article-tpl">
<%for(var i = 0; i < list.length; i++){%>
<li class="item">
  <div class="product-img">
	<img style="height:auto;" src="<%= list[i]['local_url'] %>" onerror="this.src='<?= get_img_url('default.png') ?>'" alt="Image">
  </div>
  <div class="product-info">
	<div><%= list[i]['title'] %></div>
	<div>
	  <a class="pull-right" data-id="<%= list[i]['id'] %>" data-title="<%= list[i]['title'] %>" data-img-url="<%= list[i]['local_url'] %>">添加到多图文</a>
	</div>
  </div>
</li>
<%}%>
</script>
<!--<div class="col-md-5">
<div class="alert alert-info">
	文章标题支持自动替换用户昵称，如需使用用户昵称，请使用 {{nickname}} 替代
</div>
<form role="form" action="<?= \yii\helpers\Url::toRoute('save') ?>" method="post" data-validate data-ajax>
<div class="form-group">
	<label>文章标题</label>
	<input required name="title" type="text" class="form-control" placeholder="请填写文章标题" title="请填写文章标题" value="<?= isset($title) ? $title : '' ?>">
</div>
<div class="form-group">
	<label>作者（选填）</label>
	<input name="author" type="text" class="form-control" placeholder="请填写文章作者" title="请填写文章作者" value="<?= isset($author) ? $author : '' ?>">
</div>
<div class="form-group">
	<label>封面</label>
	<br/>
	<input name="local_url" required type="hidden" class="form-control" data-width="auto" data-height="100px" data-single-upload value="<?= isset($local_url) ? $local_url : '' ?>">
	<br/>
	<div class="checkbox checkbox-info checkbox-inline">
		<input type="checkbox" id="checkbox-show-cover" name="show_cover_pic" value="1"<?php if (isset($show_cover_pic) && $show_cover_pic == 1) { ?> checked<?php } ?>/>
		<label for="checkbox-show-cover">封面显示在正文中</label>
	</div>
	<p class="help-block">支持JPG、PNG格式，较好的效果为大图360*200，小图200*200</p>
</div>
<div class="form-group">
	<label>文章摘要</label>
	<textarea name="digest" required class="form-control" rows="3" placeholder="请填写文章内容" title="请填写文章内容"><?= isset($digest) ? $digest : '' ?></textarea>
</div>
<div class="form-group">
	<label>文章内容</label>
	<textarea name="content" required class="form-control" rows="3" placeholder="请填写文章内容" title="请填写文章内容"><?= isset($content) ? $content : '' ?></textarea>
</div>
<div class="form-group">
	<label>原文链接（选填）</label>
	<input name="content_source_url" type="text" class="form-control" placeholder="请填写原文链接" title="请填写原文链接" value="<?= isset($content_source_url) ? $content_source_url : '' ?>">
</div>

<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>

<button class="btn btn-primary">保存</button>
<button class="btn" type="button" onclick="$.page.back()">返回</button>
</form>
</div>-->
</div>
<script>
$listView.on('click', '[data-del-article]', function(){
	$(this).parent().parent().remove();
	if (!$listView.children('[data-id]').length) {
		$listView.children(':eq(0)').show();
	}
});
function saveArticles(){
	var tmp = new Array();
	$listView.children('[data-id]').each(function(){
		tmp.push($(this).data('id'));
	});
	var articles = tmp.join(',');
	if (!articles) {
		$.msg.toast('请添加至少1篇文章');
		return;
	}
	$.http.post('<?= \yii\helpers\Url::toRoute('save') ?>', {id: '<?= empty($id) ? '' : $id ?>', 'article_id': articles}, function(d){
		if (d.status === 1) {
			$.msg.success(d.info, 1000, function(){
				$.page.back();
			});
		} else {
			$.msg.error(d.info);
		}
	});
}
var maxLen = 8;
require(['artTemplateNative'], function(template){
	<?php if (!empty($articles)) { ?>
	var list = <?= json_encode($articles) ?>;
	for (var i = 0; i < list.length; i++) {
		addToArticles(list[i].id, list[i].title, list[i]['local_url']);
	}
	<?php } ?>
	var $articleCon = $('#article-con').on('click', '[data-id]', function(e){
		e.preventDefault();
		var $this = $(this);
		addToArticles($this.data('id'), $this.data('title'), $this.data('img-url'));
	});
	function addToArticles(id, title, imgUrl){
		if ($listView.children('[data-id=' + id + ']').length) {
			$.msg.toast('该图文已在图文列表内');
			return;
		}
		if ($listView.children('[data-id]').length >= maxLen) {
			$.msg.toast('最多只能添加' + maxLen + '条图文');
			return;
		}
		$listView.children(':eq(0)').hide();
		$listView.append(template('articles-tpl', {list:[{id: id, title: title, 'local_url': imgUrl}]}));
	}
	$('#search-article-form').submit(function(e){
		e.preventDefault();
		$.http.get(this.action, {kw: this.kw.value}, function(d){
			if (!d || !d.length) {
				$.msg.toast('没有找到相关文章');
			} else {
				$articleCon.html(template('article-tpl', {list: d}));
			}
		});
	});
});
</script>
<link rel="stylesheet" href="<?= get_css_url() ?>wechat.css">
<style>
.wechat-list-view li:hover .wechat-tools{display: block}
.wechat-tools{display: none;position: absolute;right: 0;top:10px;}
.wechat-tools a{padding:5px;display:block;font-size: 20px;color:red;}
.wechat-list-view li:nth-child(2){border-top: none;}
.wechat-list-view .handle{cursor: move}
.wechat-list-view .wechat-list-text{bottom: 10px;font-size: 12px}
.wechat-list-img{height: 100px;width: 180px}
</style>
<?php $this->endBlock() ?>
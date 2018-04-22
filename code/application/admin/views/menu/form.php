<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>菜单信息<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 上级菜单</label>
	<div class="col-lg-10">
		<select class="form-control" name="parent_id">
			<option value="0">= 顶级菜单 =</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 菜单名</label>
	<div class="col-lg-10">
		<input type="text" name="name" value="<?= empty($name) ? '' : $name; ?>" placeholder="菜单名"
			title="请输入菜单名称" class="form-control" autofocus="true" required=""/>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">图标</label>
	<div class="col-lg-10">
		<div class="input-group">
			<span id="choose-icon" class="input-group-addon" style="cursor: pointer"><i></i></span>
			<input type="text" name="icon" value="<?php if (!empty($icon)) { echo $icon; } ?>" placeholder="图标" class="form-control"/>
			<span class="input-group-addon">
				<a href="javascript:;" id="clean-icon"><i class="fa fa-close"></i> 清除</a>
			</span>
		</div>
		<span class="help-block margin-bottom-none">可以点击图标选择，或者到 <a href="http://fontawesome.io/icons/" target="_blank">fontawesome.io/icons</a> 查找需要的图标</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 链接地址</label>
	<div class="col-lg-10">
		<input type="text" name="url" value="<?= empty($url) ? '' : $url; ?>"
			title="请输入菜单或选择链接" placeholder="顶级菜单为 #" class="form-control" required=""/>
		<div style="margin-top:5px;">
			<select class="form-control input-sm" style="display: inline-block;width:auto;" id="controller">
				<option value="">选择节点</option>
				<option value="#">- 主菜单 -</option>
			</select>
			<select class="form-control input-sm hide" id="action" style="display: inline-block;width:auto;"></select>
			<i class="text-explode"></i>
			<?php if (checkAuth('menu/refresh-node')) { ?>
			<a href="javascript:;" id="refresh-node" title="更新选择器"><i class="glyphicon glyphicon-refresh"></i>&nbsp;刷新节点</a>
			<?php } ?>
		</div>
		<span class="help-block margin-bottom-none">手动输入或者下拉选取，没有想要的选项时可以尝试点击刷新节点</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">参数</label>
	<div class="col-lg-10">
		<input type="text" name="params" value="<?= empty($params) ? '' : $params; ?>"
			placeholder="参数" class="form-control"/>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label"><b class="text-danger">*</b> 排序</label>
	<div class="col-lg-10">
		<input type="text" name="sort" value="<?= empty($sort) ? '0' : $sort; ?>" placeholder="排序"
			title="请输入排序值" class="form-control" required=""/>
		<span class="help-block margin-bottom-none">数值越小，顺序越前</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-2 control-label">状态</label>
	<div class="col-lg-10">
		<div class="radio radio-success radio-inline">
			<input required id="radio-status-1" type="radio" name="status" value="1"<?php if (empty($status) || isset($status) && intval($status) === 1){ ?> checked<?php } ?>>
			<label for="radio-status-1">启用</label>
		</div>
		<div class="radio radio-warning radio-inline">
			<input required id="radio-status-0" type="radio" name="status" value="0"<?php if (isset($status) && intval($status) === 0){ ?> checked<?php } ?>>
			<label for="radio-status-0">禁用</label>
		</div>
	</div>
</div>
<?php if (!empty($id)) { ?>
<div class="form-group">
	<label class="col-lg-2 control-label">创建时间</label>
	<div class="col-lg-10">
		<p class="form-control-static"><?= empty($create_time) ? '' : date('Y-m-d H:i:s', $create_time) ?></p>
	</div>
</div>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script'); ?>
<script>
$.http.get("<?=\yii\helpers\Url::toRoute('load-menu')?>",{},function (res) {
	if (res.length !== 0) {
		var options = "", parent_menu = "<?= empty($parent_id) ? \Yii::$app->request->get('pid', 0) : $parent_id ?>";
		res.forEach(function (item) {
			options += '<option value="' + item.id + '"' + (parent_menu == item.id ? ' selected' : item.level.split('-').length > 4 ? ' disabled' : '') + ">" + item.spl + item.name + '</option>';
		});
		$("select[name='parent_id']").append(options);
	}
});
var $pathInput=$('[name=url]'),$controllerSelect=$('#controller'),$actionSelect=$('#action').change(function(){
	$pathInput.val(this.value);
});
function initNodes(nodes) {
	var htmlArr = [''];
	for(var key in nodes){
		htmlArr.push('<option value="'+key+'">'+nodes[key].title+'</option>');
	}
	$controllerSelect.append(htmlArr.join('')).unbind('change').change(function(){
		if (this.value != '#' && this.value) {
			htmlArr = ['<option value="">请选择</option>'];
			var arr = nodes[this.value].children;
			for(var key in arr){
				htmlArr.push('<option value="'+arr[key].path+'">'+arr[key].title+'</option>');
			}
			$actionSelect.html(htmlArr).removeClass('hide');
		} else {
			$pathInput.val(this.value);
			$actionSelect.addClass('hide');
		}
	});
}
var nodes = <?= json_encode($nodes) ?>;
initNodes(nodes);
if ($pathInput.val()) {
	var val = $pathInput.val(),
	controller = val.substring(0, val.lastIndexOf('/'));
	if (typeof nodes[controller] !== 'undefined') {
		$controllerSelect.val(controller).change();
		$actionSelect.val(val);
	} else if (val == '#') {
		$controllerSelect.val('#');
	}
}
$('#refresh-node').click(function(){
	var self = this;
	$.http.get('<?=\yii\helpers\Url::toRoute('refresh-node')?>', {returnNodes: 1}, function(d){
		if (d.status === 1) {
			$actionSelect.val('').addClass('hide');
			$controllerSelect.children(':gt(1)').remove();
			initNodes(d.nodes);
			layer.tips(d.info, $controllerSelect, {
				tips: [1, '#3595CC'],
				time: 3000
			});
		} else {
			layer.tips(d.info, self, {
				tips: [1, '#a94442'],
				time: 3000
			});
		}
	});
});

var $inputIcon = $("input[name=icon]").change(function(){
	$(this).prev().children('i').attr('class', this.value || 'fa fa-circle-o');
}).change();
//选择图标
$("#choose-icon").on('click', function () {
	$.msg.iframe('选择图标','<?=\yii\helpers\Url::toRoute('icon')?>', '1000px');
});
//清除图标
$("#clean-icon").on('click',function () {
	$inputIcon.val('').change();
});
</script>
<?php $this->endBlock() ?>
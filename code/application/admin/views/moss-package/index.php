<?php $this->beginBlock('title') ?>莫斯配套<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('moss-package/add')) { ?>
    <button type="button" title="新增配套" class="btn btn-xs btn-success" data-href="<?= \yii\helpers\Url::toRoute('add') ?>"><i class="fa fa-plus"></i> 新增配套</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function getPackageStatus(k){
	return k == 1 ? '<span class="text-success">销售中</span>' : '<span class="text-danger">已下架</span>';
}
function getSaleButton(k, row, name, path) {
    if(row['package_status'] != 1){
        return getOperationButton(name, {'data-load': url.toRoute(path,{id:row[k]}), 'data-confirm-text': "确定发售该配套？"});
    }
}
function getTakeOffButton(k, row, name, path) {
    if(row['package_status'] == 1){
        return getOperationButton(name, {'data-load': url.toRoute(path,{id:row[k]}), 'data-confirm-text': "确定下架该配套？"});
    }
}

function getPackageDelButton(k, row, name, path) {
    if(row['total_sales'] == 0){
        return getOperationButton(name, {'data-load': url.toRoute(path,{id:row[k]}), 'data-confirm-text': "确定删除该数据？"});
    }
}
</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id . '/' . $this->context->action->id) ?>" data-search>
    <div class="form-group">
		<div class="input-group input-group-sm">
			<select name="status" class="form-control">
				<option value="">全部状态</option>
				<?php
				$arr_status = [
					'1' => '销售中',
					'0' => '已下架'
				];
				foreach ($arr_status as $key => $value) {
						$status = Yii::$app->request->get('status', '');
				?>
				<option value="<?= $key ?>"<?php if ($status != '' && $key == $status) { echo ' selected'; } ?>><?= $value ?></option>
				<?php } ?>
			</select>
		</div>
    </div>
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="text" name="kw" value="<?= \Yii::$app->request->get('kw', '') ?>" placeholder="配套名称" class="form-control"> 
            <span class="input-group-btn">
                <button class="btn btn-primary">搜索</button>
            </span>
        </div>
    </div>
</form>
<?=
renderTable([
    'columns' => array(
        array('field' => 'package_name', 'title' => '配套名称', 'align' => 'left'),
        array('field' => 'package_name_en', 'title' => '配套名称（英文）', 'align' => 'left'),
        array('field' => 'level_name', 'title' => '等级名称', 'align' => 'left'),
        array('field' => 'package_value', 'title' => '配套价值', 'align' => 'left'),
        array('field' => 'electron_multiple', 'title' => '电子分倍数', 'align' => 'left'),
        array('field' => 'create_time', 'title' => '发布时间', 'js' => 'showDate', 'align' => 'left'),
        array('field' => 'package_status', 'title' => '配套状态', 'js' => 'getPackageStatus'),
        array('field' => 'total_sales', 'title' => '总销量')
    ),
    'operations' => array(
        array('key' => 'id', 'text' => '编辑', 'js' => 'getHrefButton', 'path' => 'moss-package/edit'),
        array('key' => 'id', 'text' => '发售', 'js' => 'getSaleButton', 'path' => 'moss-package/sale'),
        array('key' => 'id', 'text' => '下架', 'js' => 'getTakeOffButton', 'path' => 'moss-package/take-off'),
        array('key' => 'id', 'text' => '删除', 'js' => 'getPackageDelButton', 'path' => 'moss-package/del')
    ),
    'list' => $list
])
?>

<?php $this->endBlock() ?>

<?php
if (isset($pager)) {
    $this->beginBlock('footer');
    echo $pager;
    $this->endBlock();
}
?>
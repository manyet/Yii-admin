<?php $this->beginBlock('title') ?>任务列表<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('task/add')) { ?>
    <button type="button" title="新增任务" class="btn btn-xs btn-success" data-href="<?= \yii\helpers\Url::toRoute('add') ?>"><i class="fa fa-plus"></i> 新增任务</button>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function getTaskStatus(k){
	return k == 1 ? '<span class="text-success">展示中</span>' : '<span class="text-danger">存档中</span>';
}
function getTaskMode(mode) {
    switch (parseInt(mode)) {
        case 0:
            return '仅一次';
        case 1:
            return '每日一次';
        case 2:
            return '每周一次';
        case 3:
            return '每月一次';
            
    }
}
function getSaleButton(k, row, name, path) {
    if(row['status'] != 1){
        return getOperationButton(name, {'data-load': url.toRoute(path,{id:row[k]}), 'data-confirm-text': "确定上架该任务？"});
    }
}
function getTakeOffButton(k, row, name, path) {
    if(row['status'] == 1){
        return getOperationButton(name, {'data-load': url.toRoute(path,{id:row[k]}), 'data-confirm-text': "确定下架该任务？"});
    }
}
</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id . '/' . $this->context->action->id) ?>" data-search>
    <div class="input-group input-group-sm">
        <select name="status" class="form-control">
                <option value="">全部状态</option>
                <?php
                $arr_status = [
                    '0' => '仅存档中',
                    '1' => '仅展示中'
                ];
                
                foreach ($arr_status as $key => $value) {
                        $status = Yii::$app->request->get('status', '');
                ?>
                <option value="<?= $key ?>"<?php if ($status != '' && $key == $status) { echo ' selected'; } ?>><?= $value ?></option>
                <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="text" name="kw" value="<?= \Yii::$app->request->get('kw', '') ?>" placeholder="请输入关键字" class="form-control"> 
            <span class="input-group-btn">
                <button class="btn btn-primary">搜索</button>
            </span>
        </div>
    </div>
</form>
<?=
renderTable([
    'columns' => array(
        array('field' => 'name', 'title' => '任务名称', 'align' => 'left'),
        array('field' => 'name_en', 'title' => '任务名称(英文)', 'align' => 'left'),
        array('field' => 'mode', 'title' => '任务模式', 'align' => 'left', 'js' => 'getTaskMode'),
        array('field' => 'create_time', 'title' => '创建时间', 'js' => 'showDate', 'align' => 'left'),
        array('field' => 'status', 'title' => '状态', 'js' => 'getTaskStatus')
    ),
    'operations' => array(
        array('key' => 'id', 'text' => '编辑', 'js' => 'getHrefButton', 'path' => 'task/edit'),
        array('key' => 'id', 'text' => '上架', 'js' => 'getSaleButton', 'path' => 'task/sale'),
        array('key' => 'id', 'text' => '下架', 'js' => 'getTakeOffButton', 'path' => 'task/take-off'),
        array('key' => 'id', 'text' => '删除', 'js' => 'getDelButton', 'path' => 'task/del')
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
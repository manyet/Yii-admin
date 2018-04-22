<?php $this->beginBlock('title') ?>配套订单<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<script>
function getPackageStatus(k){
	return k == 0 ? '<span class="text-success">已生效</span>' : '<span class="text-danger">已取消</span>';
}
function getRemarkButton(key, row, name, path, icon, className) {
    if(row['package_status'] == 1){
	return getOperationButton(name, {'data-modal': url.toRoute(path,{id:row[key]})}, icon, className);
    }
}
function getCancelButton(key, row, name, path, icon, className) {
    if(row['package_status'] == 0){
	return getOperationButton(name, {'data-modal': url.toRoute(path,{id:row[key]})}, icon, className);
    }
}
</script>
<form class="form-inline" role="form" action="<?= \yii\helpers\Url::toRoute($this->context->id . '/' . $this->context->action->id) ?>" data-search>
	<!--
    <div class="input-group input-group-sm">
        <select name="status" class="form-control">
                <option value="">全部状态</option>
                <?php
                $arr_status = [
                    '0' => '已生效',
                    '1' => '已取消'
                ];
                
                foreach ($arr_status as $key => $value) {
                        $status = Yii::$app->request->get('status', '');
                ?>
                <option value="<?= $key ?>"<?php if ($status != '' && $key == $status) { echo ' selected'; } ?>><?= $value ?></option>
                <?php } ?>
        </select>
    </div>
	-->
    <div class="form-group">
        <div class="input-group input-group-sm">
            <input type="text" style="min-width: 230px" name="kw" value="<?= \Yii::$app->request->get('kw', '') ?>" placeholder="请输入订单编号/玩家姓名/玩家账号" class="form-control"> 
            <span class="input-group-btn">
                <button class="btn btn-primary">搜索</button>
            </span>
        </div>
    </div>
</form>
<?=
renderTable([
    'columns' => array(
        array('field' => 'order_num', 'title' => '订单编号', 'align' => 'left'),
        array('field' => 'realname', 'title' => '玩家姓名', 'align' => 'left'),
        array('field' => 'uname', 'title' => '玩家账号', 'align' => 'left'),
        array('field' => 'package_name', 'title' => '配套名称', 'align' => 'left'),
        array('field' => 'package_value', 'title' => '配套价值', 'align' => 'left'),
        array('field' => 'buy_time', 'title' => '购买时间', 'js' => 'showDate', 'align' => 'left'),
        array('field' => 'package_status', 'title' => '配套状态', 'js' => 'getPackageStatus')
    ),
//    'operations' => array(
//        array('key' => 'id', 'text' => '取消', 'js' => 'getCancelButton', 'path' => 'package-order/cancel'),
//        array('key' => 'id', 'text' => '查看备注', 'js' => 'getRemarkButton', 'path' => 'package-order/view')
//    ),
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
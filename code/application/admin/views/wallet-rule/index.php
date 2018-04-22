<?php $this->beginBlock('title') ?>钱包规则<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<?php if (checkAuth('wallet-rule/add')) { ?>
    <!--
    <button type="button" title="添加规则" class="btn btn-xs btn-success" data-modal="<?= \yii\helpers\Url::toRoute('add') ?>"><i class="fa fa-plus"></i> 添加规则</button>
    -->
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>

<?=
renderTable([
    'columns' => array(
        array('field' => 'wallet_name', 'title' => '钱包名称', 'align' => 'left'),
    ),
    'operations' => array(
        array('key' => 'id', 'text' => '编辑', 'js' => 'getEditButton', 'path' => 'wallet-rule/edit')
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
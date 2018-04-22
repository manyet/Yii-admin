<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>订单取消后不可修改，请谨慎操作!<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-2 control-label">备注</label>
	<div class="col-lg-10">
            <textarea  name="remark" placeholder="请输入备注(可选)" class="form-control" title="请输入备注"><?= empty($remark) ? '' : $remark; ?></textarea>
	</div>
</div>

<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer'); ?>
<button type="button" class="btn btn-flat" data-dismiss="modal">关&nbsp;闭</button>
<button type="submit" class="btn btn-primary btn-flat">取消订单</button>
<?php $this->endBlock() ?>
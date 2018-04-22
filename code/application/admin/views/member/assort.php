<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?><?=$title?>奖励比例：<?=$ratio?>%<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
    <div class="form-group">
        <label class="col-lg-3 control-label"><b class="text-danger">*</b> 调整比例为</label>
        <div class="col-lg-9">
			<div class="input-group">
				<input class="form-control" min="0" max="100" required name="ratio" title="请检查比例格式" />
				<div class="input-group-addon">%</div>
			</div>
        </div>
    </div>
<?php if (!empty($id)) { ?>
    <input type="hidden" name="id" value="<?= $id ?>"/>
    <input type="hidden" name="proportion" value="<?= $ratio ?>"/>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script'); ?>
<?php $this->endBlock() ?>
<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>请选择<?=$realname?>(<?= $uname ?>)的身份<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
    <div class="form-group" align="center">
        <div class="radio radio-success radio-inline">
            <input required id="radio-status-0" type="radio" name="identity" value="1" <?php if (!empty($identity) && $identity == 1) { ?> checked<?php } ?>>
            <label for="radio-status-0">普通玩家</label>
        </div>
        <div class="radio radio-warning radio-inline">
            <input required id="radio-status-1" type="radio" name="identity" value="2" <?php if (!empty($identity) && $identity == 2) { ?> checked<?php } ?>>
            <label for="radio-status-1">领导人</label>
        </div>
    </div>
<?php if (!empty($id)) { ?>
    <input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script'); ?>
<?php $this->endBlock() ?>
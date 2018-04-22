<?php $this->beginBlock('title'); ?>消息详情<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
    <div class="form-group">
        <label class="col-lg-2 control-label">标题</label>
        <div class="col-lg-10">
            <input type="text" value="<?= empty($title) ? '' : $title ?>"
                   class="form-control"
                   autofocus="true" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">发送对象</label>
        <div class="col-lg-10">
            <input type="text" value="<?= empty($type) ? '' : $type ?>"
                   class="form-control"
                   autofocus="true" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">内容</label>
        <div class="col-lg-10">
            <textarea class="form-control" name="content" rows="3" disabled
                      ><?= empty($content) ? '' : $content ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">备注</label>
        <div class="col-lg-10">
            <textarea class="form-control" name="remark" rows="3" disabled
                      ><?= empty($remark) ? '' : $remark ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">操作人员</label>
        <div class="col-lg-10">
            <input type="text" value="<?php echo empty($username) ? '' : $username; ?>"
                   class="form-control"
                   autofocus="true" disabled>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">发布时间</label>
        <div class="col-lg-10">
            <input type="text" value="<?php echo empty($create_time) ? '' : date('Y-m-d H:i:s', $create_time); ?>"
                   class="form-control"
                   autofocus="true" disabled>
        </div>
    </div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer'); ?>
<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
<?php $this->endBlock() ?>


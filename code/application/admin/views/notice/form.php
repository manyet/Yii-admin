<?php $this->beginBlock('title'); ?>消息信息<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
    <div class="form-group">
        <label class="col-lg-2 control-label"><b class="text-danger">*</b>&nbsp;标题 </label>
        <div class="col-lg-10">
            <input type="text" name="title" value="<?= empty($title) ? '' : $title; ?>" placeholder="标题"
                   class="form-control" autofocus="true" required=""/>
        </div>
    </div>   
    <div class="form-group">
        <label class="col-lg-2 control-label"><b class="text-danger">*</b>&nbsp;发送对象</label>
        <div class="col-lg-10">
            <?php
            $selected_type = empty($type) ? [] : explode(',', $type);
            $type_arr = getUserIdentity();
            foreach ($type_arr as $k => $item) {
            ?>
			<div class="checkbox checkbox-info checkbox-inline">
				<input type="checkbox" id="checkbox-role-<?= $k ?>" name="type_id[]" value="<?= $k ?>"<?php if (in_array($k, $selected_type)) { ?> checked<?php } ?>/>
				<label for="checkbox-role-<?= $k ?>"><?= $item ?></label>
			</div>
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><b class="text-danger">*</b>&nbsp;内容</label>
        <div class="col-lg-10">
            <textarea class="form-control" name="content" rows="3" autofocus="true" required="" 
                      placeholder="内容"><?= empty($content) ? '' : $content ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">&nbsp;备注</label>
        <div class="col-lg-10">
            <textarea class="form-control" name="remark" rows="3" autofocus="true"
                      placeholder="备注"><?= empty($remark) ? '' : $remark ?></textarea>
        </div>
    </div>

    <?php if (!empty($id)) { ?>
        <div class="form-group">
            <label class="col-lg-2 control-label">创建时间</label>
            <div class="col-lg-10">
                <p class="form-control-static"><?php echo empty($create_time) ? '' : date('Y-m-d H:i:s', $create_time); ?></p>
            </div>
        </div>
    <?php } ?>
    <input type="hidden" name="id" value="<?php echo empty($id) ? 0 : $id; ?>"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('footer'); ?>
<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
<button type="submit" class="btn btn-primary">发&nbsp;送</button>
<?php $this->endBlock() ?>    
<?php /* @var $this \yii\web\View */ ?>
<div class="modal fade" data-keyboard='false' data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= \yii\helpers\Url::current() ?>" class="form-horizontal"
                  data-validate data-ajax="true" onsubmit="return false;">
                <div class="modal-header">
					<?php if (isset($this->blocks['header'])) { echo $this->blocks['header']; } else { ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
                    <h3 class="modal-title"><?php if (isset($this->blocks['title'])) { echo $this->blocks['title']; } else { ?>页面弹层<?php } ?></h3>
					<?php } ?>
                </div>
                <div class="modal-body">
					<?php if (isset($this->blocks['body'])) { echo $this->blocks['body']; } ?>
                </div>
                <div class="modal-footer">
					<?php if (isset($this->blocks['footer'])) { echo $this->blocks['footer']; } else { ?>
                    <button type="button" class="btn btn-flat" data-dismiss="modal">关&nbsp;闭</button>
                    <button type="submit" class="btn btn-primary btn-flat">保&nbsp;存</button>
					<?php } ?>
                </div>
            </form>
        </div>
    </div>
	<?php if (isset($this->blocks['script'])) { echo $this->blocks['script']; } ?>
</div>
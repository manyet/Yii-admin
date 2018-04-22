<div class="modal" data-keyboard='false' data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" id="uploadModal">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">上传文件</h3>
            </div>
            <div class="modal-body">
                <div id="container">
                    <!--头部，相册选择和格式选择-->
                    <div id="uploader">
                        <div class="queueList">
                            <div id="dndArea" class="placeholder">
                                <div id="filePicker"></div>
                            </div>
                        </div>
                        <div class="statusBar" style="display:none;">
                            <div class="progress">
                                <span class="text">0%</span>
                                <span class="percentage"></span>
                            </div>
                            <div class="info"></div>
                            <div class="btns">
                                <div id="filePicker2"></div>
                                <div class="uploadBtn">开始上传</div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo empty($id) ? 0 : $id; ?>"/>
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">关&nbsp;闭</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">保&nbsp;存</button>
            </div>
        </div>
    </div>
    <!-- JS/CSS请放到这里 -->
    <script src="<?= get_js_url() ?>upload.js"></script>
	<link href="<?= get_css_url() ?>uploader.css" rel="stylesheet"/>
	<link href="<?= get_plugin_url() ?>uploader/css/webuploader.css" rel="stylesheet"/>
</div>
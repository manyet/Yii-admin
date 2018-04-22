<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog"
     tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--<form class="avatar-form" action="upload-logo.php" enctype="multipart/form-data" method="post">-->
            <form class="avatar-form">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                    <h4 class="modal-title" id="avatar-modal-label">上传图片</h4>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <div class="avatar-upload">
                            <input class="avatar-src" name="avatar_src" type="hidden">
                            <input class="avatar-data" name="avatar_data" type="hidden">
                            <label for="avatarInput" style="line-height: 35px;">图片上传</label>
                            <button class="btn btn-primary" type="button" style="height: 35px;"
                                    onclick="$('input[id=avatarInput]').click();">请选择图片
                            </button>
                            <span id="avatar-name"></span>
                            <input class="avatar-input hide" id="avatarInput" name="avatar_file" type="file"></div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg" id="imageHead"></div>
                                <!--<div class="avatar-preview preview-md"></div>
                        <div class="avatar-preview preview-sm"></div>-->
                            </div>
                        </div>
                        <div class="row avatar-btns">
                            <div class="col-md-4">
                                <div class="btn-group">
                                    <button class="btn btn-primary fa fa-undo" data-method="rotate" data-option="-90"
                                            type="button" title="Rotate -90 degrees"> 向左旋转
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button class="btn  btn-primary fa fa-repeat" data-method="rotate" data-option="90"
                                            type="button" title="Rotate 90 degrees"> 向右旋转
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-5" style="text-align: right;">
                                <button class="btn btn-primary fa fa-arrows" data-method="setDragMode" data-option="move"
                                        type="button" title="移动">
							            <span class="docs-tooltip" data-toggle="tooltip" title=""
                                              data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
							            </span>
                                </button>
                                <button type="button" class="btn btn-primary fa fa-search-plus" data-method="zoom"
                                        data-option="0.1" title="放大图片">
							            <span class="docs-tooltip" data-toggle="tooltip" title=""
                                              data-original-title="$().cropper(&quot;zoom&quot;, 0.1)">
							              <!--<span class="fa fa-search-plus"></span>-->
							            </span>
                                </button>
                                <button type="button" class="btn btn-primary fa fa-search-minus" data-method="zoom"
                                        data-option="-0.1" title="缩小图片">
							            <span class="docs-tooltip" data-toggle="tooltip" title=""
                                              data-original-title="$().cropper(&quot;zoom&quot;, -0.1)">
							              <!--<span class="fa fa-search-minus"></span>-->
							            </span>
                                </button>
                                <button type="button" class="btn btn-primary fa fa-refresh" data-method="reset"
                                        title="重置图片">
								            <span class="docs-tooltip" data-toggle="tooltip" title=""
                                                  data-original-title="$().cropper(&quot;reset&quot;)"
                                                  aria-describedby="tooltip866214"></span>
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-block avatar-save fa fa-save" type="button">保存修改</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
<script type="text/javascript">
require(['uploader-single'], function(CropAvatar){

new CropAvatar($('#crop-avatar'));

var $input = $('#avatarInput').on('change', function (e) {
	var filemaxsize = 1024 * 5;//文件大小，单位KB
	var target = $(e.target);
	var Size = target[0].files[0].size / 1024;
	if (Size > filemaxsize) {
		$.msg.toast('图片过大，请重新选择');
		$(".avatar-wrapper").childre().remove;
		return false;
	}
	if (!this.files[0].type.match(/image.*/)) {
		$.msg.toast('请选择正确的图片');
	} else {
		var filename = document.querySelector("#avatar-name");
		var teststr = document.querySelector("#avatarInput").value;
		filename.innerHTML = teststr.match(/[^\\]+\.[^\(]+/i); //直接完整文件名的
	}
});

$(".avatar-save").on("click", function () {
	if (!$input.val()) {
		$.msg.toast('请选择图片');
		return;
	}
	var img_lg = document.getElementById('imageHead');
	// 截图小的显示框内的内容
	html2canvas(img_lg, {
		allowTaint: true,
		taintTest: false,
		onrendered: function (canvas) {
			canvas.id = "mycanvas";
			//生成base64图片数据
			var dataUrl = canvas.toDataURL("image/jpeg");
			var newImg = document.createElement("img");
			newImg.src = dataUrl;
			imagesAjax(dataUrl)
		}
	});
});

});

var errorMsg = '图片上传失败，请稍候重试', handleUrl = '<?= \Yii::$app->request->get('url', ''); ?>';
function imagesAjax(src) {
	var data = {};
	data.img = src;
	data.jid = $('#jid').val();
	data['<?= Yii::$app->request->csrfParam ?>'] = '<?= Yii::$app->request->getCsrfToken() ?>';
	$.ajax({
		url: handleUrl || "<?= yii\helpers\Url::toRoute('cropper-submit') ?>",
		data: data,
		type: "POST",
		dataType: 'json',
		beforeSend: function() {
			$.msg.loading();
		},
		success: function (re) {
			if (re.status === 1) {
				$('#<?= Yii::$app->request->get('id') ?>').attr('src', src).prev().val(re.url).change();
				$('#avatar-modal').modal('hide');
			} else {
				$.msg.alert(re.info);
			}
		},
		error:function(){
			$.msg.alert(errorMsg);
		},
		complete: function() {
			$.msg.closeLoading();
		}
	});
}
</script>

</div>
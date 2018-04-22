<?php $this->beginBlock('title') ?>
任务列表 > <?= $admin_title?>任务
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<button type="button" onclick="$.page.back();" class="btn btn-xs btn-default">返回上一页</button>
<button type="button" class="btn btn-xs btn-primary" id="preview">预览</button>
<button type="button" id="post" class="btn btn-xs btn-primary">确认保存</button>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<form id="form" class="form-horizontal" method="POST" action="#"
      data-validate data-ajax="true" onsubmit="return false;">
    <div class="form-group">
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 任务模式：</label>
			<div>
				<select name="mode" class="form-control">
					<option value="0"<?php if ($mode == 0) { ?> selected<?php } ?>>仅一次</option>
					<option value="1"<?php if ($mode == 1) { ?> selected<?php } ?>>每日一次</option>
					<option value="2"<?php if ($mode == 2) { ?> selected<?php } ?>>每周一次</option>
					<option value="3"<?php if ($mode == 3) { ?> selected<?php } ?>>每月一次</option>
				</select>
			</div>
		</div>
    </div>
    <div class="form-group">
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 任务名称</label>
			<div>
				<input type="text" name="name" value="<?= empty($name) ? '' : $name; ?>"
					   placeholder="" class="form-control" required />
			</div>
		</div>
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 任务名称（英文）</label>
			<div>
				<input type="text" name="name_en" value="<?= empty($name_en) ? '' : $name_en; ?>"
					   placeholder="" class="form-control" required />
			</div>
		</div>
    </div>
    <div class="form-group">
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 任务描述</label>
			<div>
				<textarea name="description" placeholder="" class="form-control" required><?= empty($description) ? '' : $description; ?></textarea>
			</div>
		</div>
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 任务描述（英文）</label>
			<div>
				<textarea name="description_en" placeholder="" class="form-control" required><?= empty($description_en) ? '' : $description_en; ?></textarea>
			</div>
		</div>
    </div>
    <div class="form-group">
		<div class="col-lg-12">
        <table style="width: 100%; text-align: center;" class="table">
            <tbody>
                <tr>
                    <td>勾选</td>
                    <td>序号</td>
                    <td><b class="text-danger">*</b>图片上传</td>
                    <td>跳转链接</td>
                    <td>广告商</td>
                    <td>广告费</td>
                    <td>备注</td>
                </tr>
                <tr>
                    <td style="width: 5%">
						<div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="ad_check_1" name="ad_check_1" value="1" <?php if (!empty($ad_check_1) && $ad_check_1 == 1) { ?> checked<?php } ?>>
                            <label for="ad_check_1"></label>
                        </div>
					</td>
                    <td style="width: 5%">1</td>
                    <td style="width: 10%">
                        <input type="hidden" name="ad_pic_1" value="<?= empty($ad_pic_1) ? '' : $ad_pic_1; ?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_url_1" value="<?= empty($ad_url_1) ? '' : $ad_url_1; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_merchant_1" value="<?= empty($ad_merchant_1) ? '' : $ad_merchant_1; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_price_1" onchange="this.value = fomatFloat(this.value,2,1)" value="<?= empty($ad_price_1) ? '' : $ad_price_1; ?>" class="form-control"/>
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_remark_1" value="<?= empty($ad_remark_1) ? '' : $ad_remark_1; ?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
					<td style="width: 5%">
						<div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="ad_check_2" name="ad_check_2" value="1" <?php if (!empty($ad_check_2) && $ad_check_2 == 1) { ?> checked<?php } ?>>
                            <label for="ad_check_2"></label>
                        </div>
					</td>
                    <td style="width: 5%">2</td>
                    <td style="width: 10%">
                        <input type="hidden" name="ad_pic_2" value="<?= empty($ad_pic_2) ? '' : $ad_pic_2; ?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_url_2" value="<?= empty($ad_url_2) ? '' : $ad_url_2; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_merchant_2" value="<?= empty($ad_merchant_2) ? '' : $ad_merchant_2; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_price_2" onchange="this.value = fomatFloat(this.value,2,1)" value="<?= empty($ad_price_2) ? '' : $ad_price_2; ?>" class="form-control"/>
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_remark_2" value="<?= empty($ad_remark_2) ? '' : $ad_remark_2; ?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
					<td style="width: 5%">
						<div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="ad_check_3" name="ad_check_3" value="1" <?php if (!empty($ad_check_3) && $ad_check_3 == 1) { ?> checked<?php } ?>>
                            <label for="ad_check_3"></label>
                        </div>
					</td>
                    <td style="width: 5%">3</td>
                    <td style="width: 10%">
                        <input type="hidden" name="ad_pic_3" value="<?= empty($ad_pic_3) ? '' : $ad_pic_3; ?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_url_3" value="<?= empty($ad_url_3) ? '' : $ad_url_3; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_merchant_3" value="<?= empty($ad_merchant_3) ? '' : $ad_merchant_3; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_price_3" onchange="this.value = fomatFloat(this.value,2,1)" value="<?= empty($ad_price_3) ? '' : $ad_price_3; ?>" class="form-control"/>
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_remark_3" value="<?= empty($ad_remark_3) ? '' : $ad_remark_3; ?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
					<td style="width: 5%">
						<div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="ad_check_4" name="ad_check_4" value="1" <?php if (!empty($ad_check_4) && $ad_check_4 == 1) { ?> checked<?php } ?>>
                            <label for="ad_check_4"></label>
                        </div>
					</td>
                    <td style="width: 5%">4</td>
                    <td style="width: 10%">
                        <input type="hidden" name="ad_pic_4" value="<?= empty($ad_pic_4) ? '' : $ad_pic_4; ?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_url_4" value="<?= empty($ad_url_4) ? '' : $ad_url_4; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_merchant_4" value="<?= empty($ad_merchant_4) ? '' : $ad_merchant_4; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_price_4" onchange="this.value = fomatFloat(this.value,2,1)" value="<?= empty($ad_price_4) ? '' : $ad_price_4; ?>" class="form-control"/>
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_remark_4" value="<?= empty($ad_remark_4) ? '' : $ad_remark_4; ?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
					<td style="width: 5%">
						<div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="ad_check_5" name="ad_check_5" value="1" <?php if (!empty($ad_check_5) && $ad_check_5 == 1) { ?> checked<?php } ?>>
                            <label for="ad_check_5"></label>
                        </div>
					</td>
                    <td style="width: 5%">5</td>
                    <td style="width: 10%">
                        <input type="hidden" name="ad_pic_5" value="<?= empty($ad_pic_5) ? '' : $ad_pic_5; ?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_url_5" value="<?= empty($ad_url_5) ? '' : $ad_url_5; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_merchant_5" value="<?= empty($ad_merchant_5) ? '' : $ad_merchant_5; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_price_5" onchange="this.value = fomatFloat(this.value,2,1)" value="<?= empty($ad_price_5) ? '' : $ad_price_5; ?>" class="form-control"/>
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_remark_5" value="<?= empty($ad_remark_5) ? '' : $ad_remark_5; ?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
					<td style="width: 5%">
						<div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="ad_check_6" name="ad_check_6" value="1" <?php if (!empty($ad_check_6) && $ad_check_6 == 1) { ?> checked<?php } ?>>
                            <label for="ad_check_6"></label>
                        </div>
					</td>
                    <td style="width: 5%">6</td>
                    <td style="width: 10%">
                        <input type="hidden" name="ad_pic_6" value="<?= empty($ad_pic_6) ? '' : $ad_pic_6; ?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_url_6" value="<?= empty($ad_url_6) ? '' : $ad_url_6; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_merchant_6" value="<?= empty($ad_merchant_6) ? '' : $ad_merchant_6; ?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="ad_price_6" onchange="this.value = fomatFloat(this.value,2,1)" value="<?= empty($ad_price_6) ? '' : $ad_price_6; ?>" class="form-control"/>
                    </td>
                    <td style="width: 25%">
                        <input type="text" name="ad_remark_6" value="<?= empty($ad_remark_6) ? '' : $ad_remark_6; ?>" class="form-control"/>
                    </td>
                </tr>
            </tbody>
            <input type="hidden" name="id" value="<?= empty($id) ? '' : $id; ?>"/>
        </table>
		</div>
    </div>
</form>
<script>
$('#post').click(function () {
    $.http.post('<?= \yii\helpers\Url::current() ?>', $('#form').serialize(), function (d) {
        if (d.status === 1) {
            $.msg.success(d.info, 2000, function(){
				$.page.back();
			});
        } else {
            $.msg.error(d.info);
        }
    })
})

// 将金额类型转为数字类型  
function toNum(str) {  
    return str.replace(/\,|\￥/g, "");  
} 
//保留n位小数并格式化输出t位保留小数（不足的部分补0）
function fomatFloat(num, n, t) {
    if(t === 0){
        var reg = /^\d+(\.\d+)?$/;
    }else{
        var reg = /^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/;
    }
    if(!reg.test(num)){
        return '';
    }
    num = parseFloat(toNum(num).replace('/(\.\d{' + n + '})\d+$/',"$1")).toFixed(n).toString().split(".");
    return num.join(".");
}

$("button#preview").on('click', function () {
    var Picture1=$("input[ name='ad_pic_1']").val();
    var Picture2=$("input[ name='ad_pic_2']").val();
    var Picture3=$("input[ name='ad_pic_3']").val();
    var Picture4=$("input[ name='ad_pic_4']").val();
    var Picture5=$("input[ name='ad_pic_5']").val();
    var Picture6=$("input[ name='ad_pic_6']").val();
    $.msg.iframe('预览','<?= Yii::$app->params['frontUrl'] . '/main/top.html' ?>'+'?advertising_Picture1='+Picture1+
        '&advertising_Picture2='+Picture2+'&advertising_Picture3='+Picture3+'&advertising_Picture4='+Picture4+
        '&advertising_Picture5='+Picture5+'&advertising_Picture6='+Picture6, '1000px','426px');
});
</script>
<?php $this->endBlock() ?>
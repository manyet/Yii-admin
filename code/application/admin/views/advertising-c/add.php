<?php $this->beginBlock('title') ?>
MESPC广告位C > <?=$this->params['title']?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
    <style>.form-horizontal .checkbox{padding-top: 1px}</style>
<button type="button" onclick="$.page.back();" class="btn btn-xs btn-default">返回上一页</button>
<button type="button" id="yu" class="btn btn-xs btn-primary">预览</button>
<button type="button" id="post" class="btn btn-xs btn-primary">确认保存</button>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
 <form id="form" class="form-horizontal" method="POST" action="#"
          data-validate data-ajax="true" onsubmit="return false;">
    <div class="form-group">
        <div class="col-lg-6">
			<label><b class="text-danger">*</b> 广告组名称</label>
			<div>
				<input type="text" name="advertising_name" value="<?= empty($advertising_name) ? '' : $advertising_name; ?>"
					   placeholder="" class="form-control" required />
			</div>
		</div>
        <div class="col-lg-6">
			<label><b class="text-danger">*</b> 广告组描述</label>
			<div>
				<input type="text" name="advertising_describe" value="<?= empty($advertising_describe) ? '' : $advertising_describe; ?>"
					   placeholder="" class="form-control" required />
			</div>
		</div>
    </div>
    <div class="form-group">
		<div class="col-lg-12">
        <table style="width: 100%; text-align: center;" class="table">
            <tbody>
                <tr>
                    <td>Top</td>
                    <td>*图片上传</td>
                    <td>*国旗上传</td>
                    <td>*赌场名称</td>
                    <td>*赌资金额</td>
                    <td>*玩家人数</td>
                    <td>跳转链接</td>
                </tr>
                <tr>

                    <td style="width: 5%">1</td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture1" value="<?=empty($advertising_Picture1) ? '' : $advertising_Picture1;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="flag_Picture1" value="<?=empty($flag_Picture1) ? '' : $flag_Picture1;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="casino_name1" value="<?=empty($casino_name1) ? '' : $casino_name1;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price1" value="<?=empty($price1) ? '' : $price1;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="number1" value="<?=empty($number1) ? '' : $number1;?>" class="form-control"/>
                    </td>
                    <td style="width: 24%">
                        <input type="text" name="advertising_Path1" value="<?=empty($advertising_Path1) ? '' : $advertising_Path1;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>

                    <td style="width: 5%">2</td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture2" value="<?=empty($advertising_Picture2) ? '' : $advertising_Picture2;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="flag_Picture2" value="<?=empty($flag_Picture2) ? '' : $flag_Picture2;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="casino_name2" value="<?=empty($casino_name2) ? '' : $casino_name2;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price2" value="<?=empty($price2) ? '' : $price2;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="number2" value="<?=empty($number2) ? '' : $number2;?>" class="form-control"/>
                    </td>
                    <td style="width: 24%">
                        <input type="text" name="advertising_Path2" value="<?=empty($advertising_Path2) ? '' : $advertising_Path2;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%">3</td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture3" value="<?=empty($advertising_Picture3) ? '' : $advertising_Picture3;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="flag_Picture3" value="<?=empty($flag_Picture3) ? '' : $flag_Picture3;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="casino_name3" value="<?=empty($casino_name3) ? '' : $casino_name3;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price3" value="<?=empty($price3) ? '' : $price3;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="number3" value="<?=empty($number3) ? '' : $number3;?>" class="form-control"/>
                    </td>
                    <td style="width: 24%">
                        <input type="text" name="advertising_Path3" value="<?=empty($advertising_Path3) ? '' : $advertising_Path3;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%">4</td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture4" value="<?=empty($advertising_Picture4) ? '' : $advertising_Picture4;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="flag_Picture4" value="<?=empty($flag_Picture4) ? '' : $flag_Picture4;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="casino_name4" value="<?=empty($casino_name4) ? '' : $casino_name4;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price4" value="<?=empty($price4) ? '' : $price4;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="number4" value="<?=empty($number4) ? '' : $number4;?>" class="form-control"/>
                    </td>
                    <td style="width: 24%">
                        <input type="text" name="advertising_Path4" value="<?=empty($advertising_Path4) ? '' : $advertising_Path4;?>" class="form-control"/>
                    </td>
                </tr>
            </tbody>
            <input type="hidden" name="id" value="<?=empty($id) ? '' : $id;?>"/>
        </table>
		</div>
    </div>
</form>
<script>
$('#post').click(function () {
    $.http.post('<?=\yii\helpers\Url::toRoute('addlist')?>', $('#form').serialize(), function (d) {
        if (d.status == 0) {
            $.msg.error(d.info);
            $('.switch-animbg').attr('checked', false);
        } else {
            $.msg.success(d.info);
            setTimeout(function () {
                $.page.back();
            }, 2000);
        }
    })
})
$("button#yu").on('click', function () {
var Picture1=$("input[ name='advertising_Picture1']").val();
var Picture2=$("input[ name='advertising_Picture2']").val();
var Picture3=$("input[ name='advertising_Picture3']").val();
var Picture4=$("input[ name='advertising_Picture4']").val();
$.msg.iframe('预览','<?= Yii::$app->params['frontUrl'] . '/main/casion.html' ?>'+'?advertising_Picture1='+Picture1+
        '&advertising_Picture2='+Picture2+'&advertising_Picture3='+Picture3+'&advertising_Picture4='+Picture4, '1000px','450px');
});
</script>
<?php $this->endBlock() ?>
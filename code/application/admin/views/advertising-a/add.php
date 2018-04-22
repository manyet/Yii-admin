<?php $this->beginBlock('title') ?>
MESPC广告位A > <?=$this->params['title']?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
    <style>.form-horizontal .checkbox{padding-top: 1px}</style>
<button type="button" onclick="$.page.back();" class="btn btn-xs btn-default">返回上一页</button>
<button type="button" class="btn btn-xs btn-primary" id="yu">预览</button>
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
                    <td>勾选</td>
                    <td>序号</td>
                    <td>*手机广告图</td>
                    <td>*电脑广告图</td>
                    <td>跳转链接</td>
                    <td>广告商</td>
                    <td>广告费</td>
                    <td>备注</td>
                </tr>
                <tr>
                    <td style="width: 5%;">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-package-buy1" name="c_open1" value="1" <?php if (!empty($c_open1) && $c_open1 == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-package-buy1"></label>
                        </div>
                    </td>
                    <td style="width: 5%">1</td>
                    <td style="width: 10%">
                        <input type="hidden" name="wap_Picture1" value="<?=empty($wap_Picture1) ? '' : $wap_Picture1;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture1" value="<?=empty($advertising_Picture1) ? '' : $advertising_Picture1;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="advertising_Path1" value="<?=empty($advertising_Path1) ? '' : $advertising_Path1;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="advertisers_1" value="<?=empty($advertisers_1) ? '' : $advertisers_1;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price1" value="<?=empty($price1) ? '' : $price1;?>" class="form-control"/>
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="note1" value="<?=empty($note1) ? '' : $note1;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-package-buy2" name="c_open2" value="1" <?php if (!empty($c_open2) && $c_open2 == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-package-buy2"></label>
                        </div>
                    </td>
                    <td style="width: 5%">2</td>
                    <td style="width: 10%">
                        <input type="hidden" name="wap_Picture2" value="<?=empty($wap_Picture2) ? '' : $wap_Picture2;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture2" value="<?=empty($advertising_Picture2) ? '' : $advertising_Picture2;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="advertising_Path2" value="<?=empty($advertising_Path2) ? '' : $advertising_Path2;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="advertisers_2" value="<?=empty($advertisers_2) ? '' : $advertisers_2;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price2" value="<?=empty($price2) ? '' : $price2;?>" class="form-control"/>
                    </td>
                    <td style="width: 10%">
                        <input type="text" name="note2" value="<?=empty($note2) ? '' : $note2;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-package-buy3" name="c_open3" value="1" <?php if (!empty($c_open3) && $c_open3 == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-package-buy3"></label>
                        </div>
                    </td>
                    <td style="width: 5%">3</td>
                    <td style="width: 10%">
                        <input type="hidden" name="wap_Picture3" value="<?=empty($wap_Picture3) ? '' : $wap_Picture3;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture3" value="<?=empty($advertising_Picture3) ? '' : $advertising_Picture3;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="advertising_Path3" value="<?=empty($advertising_Path3) ? '' : $advertising_Path3;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="advertisers_3" value="<?=empty($advertisers_3) ? '' : $advertisers_3;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price3" value="<?=empty($price3) ? '' : $price3;?>" class="form-control"/>
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="note3" value="<?=empty($note3) ? '' : $note3;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-package-buy4" name="c_open4" value="1" <?php if (!empty($c_open4) && $c_open4 == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-package-buy4"></label>
                        </div>
                    </td>
                    <td style="width: 5%">4</td>
                    <td style="width: 10%">
                        <input type="hidden" name="wap_Picture4" value="<?=empty($wap_Picture4) ? '' : $wap_Picture4;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture4" value="<?=empty($advertising_Picture4) ? '' : $advertising_Picture4;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="advertising_Path4" value="<?=empty($advertising_Path4) ? '' : $advertising_Path4;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="advertisers_4" value="<?=empty($advertisers_4) ? '' : $advertisers_4;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price4" value="<?=empty($price4) ? '' : $price4;?>" class="form-control"/>
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="note4" value="<?=empty($note4) ? '' : $note4;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-package-buy5" name="c_open5" value="1" <?php if (!empty($c_open6) && $c_open6 == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-package-buy5"></label>
                        </div>
                    </td>
                    <td style="width: 5%">5</td>
                    <td style="width: 10%">
                        <input type="hidden" name="wap_Picture5" value="<?=empty($wap_Picture5) ? '' : $wap_Picture5;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture5" value="<?=empty($advertising_Picture5) ? '' : $advertising_Picture5;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="advertising_Path5" value="<?=empty($advertising_Path5) ? '' : $advertising_Path5;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="advertisers_5" value="<?=empty($advertisers_5) ? '' : $advertisers_5;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price5" value="<?=empty($price5) ? '' : $price5;?>" class="form-control"/>
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="note5" value="<?=empty($note5) ? '' : $note5;?>" class="form-control"/>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-package-buy6" name="c_open6" value="1" <?php if (!empty($c_open6) && $c_open6 == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-package-buy6"></label>
                        </div>
                    </td>
                    <td style="width: 5%">6</td>
                    <td style="width: 10%">
                        <input type="hidden" name="wap_Picture6" value="<?=empty($wap_Picture6) ? '' : $wap_Picture6;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 10%">
                        <input type="hidden" name="advertising_Picture6" value="<?=empty($advertising_Picture6) ? '' : $advertising_Picture6;?>" data-single-upload data-height="50px" data-width="50px" />
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="advertising_Path6" value="<?=empty($advertising_Path6) ? '' : $advertising_Path6;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="advertisers_6" value="<?=empty($advertisers_6) ? '' : $advertisers_6;?>" class="form-control"/>
                    </td>
                    <td style="width: 15%">
                        <input type="text" name="price6" value="<?=empty($price6) ? '' : $price6;?>" class="form-control"/>
                    </td>
                    <td style="width: 20%">
                        <input type="text" name="note6" value="<?=empty($note6) ? '' : $note6;?>" class="form-control"/>
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
    var Picture5=$("input[ name='advertising_Picture5']").val();
    var Picture6=$("input[ name='advertising_Picture6']").val();
    $.msg.iframe('预览','<?= Yii::$app->params['frontUrl'] . '/main/top.html' ?>'+'?advertising_Picture1='+Picture1+
        '&advertising_Picture2='+Picture2+'&advertising_Picture3='+Picture3+'&advertising_Picture4='+Picture4+
        '&advertising_Picture5='+Picture5+'&advertising_Picture6='+Picture6, '1000px','426px');
});

</script>
<?php $this->endBlock() ?>
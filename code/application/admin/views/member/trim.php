<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?><?=$title?><?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-3 control-label"><?=$title?>余额</label>
	<div class="col-lg-9">
		<p class="form-control-static"><?=$integral?></p>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3">
		<select name="type" class="form-control" id="Type">
			<option value="">调整形式</option>
			<option value="1">增加</option>
			<option value="2">减少</option>
		</select>
	</label>
	<div class="col-lg-9">
		<input class="form-control" type="number" placeholder="请输入正整数"   name="value" required id="money" title="请检查调整金额">
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 control-label">变动后余额</label>
	<div class="col-lg-9">
		<p class="form-control-static company_integral"><?=$integral?></p>
	</div>
</div>
<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<input type="hidden" name="company_integral" value="<?=$integral?>"/>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script'); ?>
<script>
$("#money,#Type").on('change keyup',function()
{
	var val = $("#money").val();
	var type=$("select[name=type]").val();
	var money='<?=$integral?>';
	if(type==1){
		var company_integral=money*1 + val*1;
		$('.company_integral').html(company_integral.toFixed(2));
	}else if(type==2){
		var company_integral=money - val;
		$('.company_integral').html(company_integral.toFixed(2));
	}else{
		$('.company_integral').html('请选择调整形式');

	}

});
</script>
<?php $this->endBlock() ?>
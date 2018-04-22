<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>公司分<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-3 control-label">公司分余额</label>
	<div class="col-lg-9">
		<p class="form-control-static"><?=$company_integral?></p>
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
	   <input class="form-control" type="number" required mt="10" title="调整金额必须是10的倍数" placeholder="请输入10的倍数" name="value" id="money">
		<div class="radio radio-success radio-inline">
			<input required id="radio-status-0" type="radio" name="identity" value="1" <?php if (!empty($identity) && $identity == 1) { ?> checked<?php } ?>>
			<label for="radio-status-0">已实际收款</label>
		</div>
		<div class="radio radio-warning radio-inline">
			<input required id="radio-status-1" type="radio" name="identity" value="2" <?php if (!empty($identity) && $identity == 2) { ?> checked<?php } ?>>
			<label for="radio-status-1">无收益调整</label>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-lg-3 control-label">变动后余额</label>
	<div class="col-lg-9">
		<p class="form-control-static company_integral"><?=$company_integral?></p>
	</div>
</div>
<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<input type="hidden" name="company_integral" value="<?=$company_integral?>"/>
<?php } ?>
<?php $this->endBlock() ?>

<?php $this->beginBlock('script'); ?>
<script>
$("#money,#Type").on('change keyup', function() {
	var val = $("#money").val();
	var type=$("select[name=type]").val();
	var money='<?=$company_integral?>';
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
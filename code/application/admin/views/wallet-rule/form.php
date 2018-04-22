<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?><?= empty($wallet_name) ? '' : $wallet_name; ?> 规则编辑<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<style>.form-horizontal .checkbox{padding-top: 1px}</style>
<table class="table">
	<tbody>
		<tr class="border-top-none">
			<td>
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-buy" name="package_buy[open]" value="1" <?php if (!empty($package_buy_open) && $package_buy_open == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-buy">开启购买配套</label>
				</div>
			</td>
			<td>
占配套
<input type="text" name="package_lowest_ratio" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 80px;height: 26px;" value="<?= empty($package_lowest_ratio) ? '' : $package_lowest_ratio; ?>" class="form-control inline" title="请输入最低比例"/>
%
至
<input type="text" name="package_highest_ratio" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 80px;height: 26px;" value="<?= empty($package_highest_ratio) ? '' : $package_highest_ratio; ?>" class="form-control inline" title="请输入最高比例"/>
%
			</td>
		</tr>
		<tr>
			<td>
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-recharge" name="package_recharge[open]" value="1" <?php if (!empty($package_recharge_open) && $package_recharge_open == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-recharge">开启充值配套</label>
				</div>
			</td>
			<td>
占充值
<input type="text" name="recharge_lowest_ratio" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 80px;height: 26px;" value="<?= empty($recharge_lowest_ratio) ? '' : $recharge_lowest_ratio; ?>" class="form-control inline" title="请输入最低比例"/>
%
至
<input type="text" name="recharge_highest_ratio" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 80px;height: 26px;" value="<?= empty($recharge_highest_ratio) ? '' : $recharge_highest_ratio; ?>" class="form-control inline" title="请输入最高比例"/>
%
最低使用
<input type="text" name="recharge_lowest_value" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 80px;height: 26px;" value="<?= empty($recharge_lowest_value) ? '' : $recharge_lowest_value; ?>" class="form-control inline" title="请输入最低分值"/>

			</td>
		</tr>
		<tr>
			<td>
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-recast" name="package_recast[open]" value="1" <?php if (!empty($package_recast_open) && $package_recast_open == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-recast">开启复投配套</label>
				</div>
			</td>
			<td>
复投最低值
<input type="text" name="recast_lowest_value" onchange="this.value = fomatFloat(this.value,2,0)" style="width: 80px;height: 26px;" value="<?= empty($recast_lowest_value) ? '' : $recast_lowest_value; ?>" class="form-control inline" title="请输入最低分值"/>
且为
<input type="text" name="recast_multiple" onchange="this.value = fomatFloat(this.value,0,0)" style="width: 80px;height: 26px;" value="<?= empty($recast_multiple) ? '0' : $recast_multiple; ?>" class="form-control inline" title="请输入倍数"/>
的倍数
			</td>
		</tr>
		<tr>
			<td>
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-transfer-score" name="transfer_score[open]" value="1" <?php if (!empty($transfer_score_open) && $transfer_score_open == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-transfer-score">开启转让分数</label>
				</div>
			</td>
			<td>
转分最低值
<input type="text" name="transfer_lowest_value" onchange="this.value = fomatFloat(this.value,2,0)" style="width: 80px;height: 26px;" value="<?= empty($transfer_lowest_value) ? '' : $transfer_lowest_value; ?>" class="form-control inline" title="请输入最低分值"/>
且为
<input type="text" name="transfer_multiple" onchange="this.value = fomatFloat(this.value,0,0)" style="width: 80px;height: 26px;" value="<?= empty($transfer_multiple) ? '0' : $transfer_multiple; ?>" class="form-control inline" title="请输入倍数"/>
的倍数
			</td>
		</tr>
		<tr class="border-top-none">
			<td>
			</td>
			<td>
转入对方公司分，比例
<input type="text" name="company_score_ratio" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 150px;height: 26px;" value="<?= empty($company_score_ratio) ? '' : $company_score_ratio; ?>" class="form-control inline" title="请输入比例"/>
%
			</td>
		</tr>
		<tr class="border-top-none">
			<td>
			</td>
			<td>
转入对方现金分，比例
<input type="text" name="cash_score_ratio" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 150px;height: 26px;" value="<?= empty($cash_score_ratio) ? '' : $cash_score_ratio; ?>" class="form-control inline" title="请输入比例"/>
%
			</td>
		</tr>
		<tr class="border-top-none">
			<td>
			</td>
			<td>
转入对方娱乐分，比例
<input type="text" name="entertainment_score_ratio" onchange="this.value = fomatFloat(this.value,1,0)" style="width: 150px;height: 26px;" value="<?= empty($entertainment_score_ratio) ? '' : $entertainment_score_ratio; ?>" class="form-control inline" title="请输入比例"/>
%
			</td>
		</tr>
	</tbody>
</table>

<?php if (!empty($id)) { ?>
    <input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>

<script>
// 将金额类型转为数字类型  
function toNum(str) {  
    return str.replace(/\,|\￥/g, "");  
} 
//保留1位小数并格式化输出（不足的部分补0）
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
</script>    
<?php $this->endBlock() ?>
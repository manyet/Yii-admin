<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>莫斯配套<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<button type="button" onclick="$.page.back();" class="btn btn-xs btn-default">返回上一页</button>
<button type="button" id="post" class="btn btn-xs btn-primary">确认发布</button>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content'); ?>
<style>.form-horizontal .checkbox, .form-horizontal .checkbox-inline, .form-horizontal .radio, .form-horizontal .radio-inline{padding-top: 1px}</style>
<form id="form" class="form-horizontal" action="<?= yii\helpers\Url::current() ?>" data-ajax data-validate method="post">
    <div class="form-group">
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 配套名称</label>
			<div>
				<input class="form-control" title="请输入配套名称" required="" name="package_name" type="text" value="<?= empty($package_name) ? '' : $package_name ?>"/>
			</div>
        </div>
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> Package name</label>
			<div>
				<input class="form-control" title="请输入配套名称" required="" name="package_name_en" type="text" value="<?= empty($package_name_en) ? '' : $package_name_en ?>"/>
			</div>
        </div>
    </div>
    <div class="form-group">
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 配套价值($)</label>
			<div>
				<input class="form-control" title="请输入配套价值" onchange="this.value=fomatFloat(this.value,2,0)" required="" name="package_value" type="text" value="<?= empty($package_value) ? '' : $package_value ?>"/>
			</div>
        </div>
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 等级名称</label>
			<div>
				<input class="form-control" title="请输入等级名称" required="" name="level_name" type="text" value="<?= empty($level_name) ? '' : $level_name ?>"/>
			</div>
        </div>
    </div>
    <div class="form-group">
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 电子分倍数</label>
			<div>
				<input class="form-control" title="请输入电子分倍数" onchange="this.value=fomatFloat(this.value,1,0)" required="" name="electron_multiple" type="text" value="<?= empty($electron_multiple) ? '' : $electron_multiple ?>"/>
			</div>
        </div>
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 显示人数</label>
			<div>
				<input class="form-control" title="请输入显示人数" onchange="this.value=fomatFloat(this.value,0,0)" required="" name="count" type="text" value="<?= empty($count) ? 0 : $count ?>"/>
			</div>
        </div>
    </div>

    <div class="form-group">
		<div class="col-lg-6">
			<input type="hidden" name="package_image_path" value="<?= empty($package_image_path) ? '' : $package_image_path; ?>" data-single-upload data-width="360px" data-height="250px"/>
			<div class="help-block">建议尺寸360 X 250，支持JPG、PNG等格式</div>
		</div>
		<div class="col-lg-6">
			<label class="form-inline"><b class="text-danger">*</b> 配套业务(多选)</label>
			<div class="form-inline row">
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-1" name="daily_dividend[checked]" value="1" <?php if (!empty($daily_dividend_check) && $daily_dividend_check == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-1">每日分红 → 奖励比例</label>
				</div>
				<input type="text" name="daily_dividend[rate]" onchange="this.value=fomatFloat(this.value,1,0)" style="width: 70px;height: 26px;" value="<?= empty($daily_dividend_ratio) ? '' : $daily_dividend_ratio; ?>"
						   class="form-control" title="请输入每日分红比例"/> %
			</div>

			<div class="form-inline row">
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-2" name="task_benefit[checked]" value="1" <?php if (!empty($task_benefit_check) && $task_benefit_check == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-2">任务收益 → 奖励比例</label>
				</div>
				<input type="text" name="task_benefit[rate]" onchange="this.value=fomatFloat(this.value,1,0)" style="width:70px;height: 26px;" value="<?= empty($task_benefit_ratio) ? '' : $task_benefit_ratio; ?>"
					   class="form-control" title="请输入任务收益比例"/> %
			</div>

			<div class="form-inline row">
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-3" name="direct_reward[checked]" value="1" <?php if (!empty($direct_reward_check) && $direct_reward_check == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-3">直推奖励 → 奖励比例</label>
				</div>
				<input type="text" name="direct_reward[rate]" onchange="this.value=fomatFloat(this.value,1,0)" style="width:70px;height: 26px;" value="<?= empty($direct_reward_ratio) ? '' : $direct_reward_ratio; ?>"
					   class="form-control" title="请输入直推奖励比例"/> %
			</div>

			<div class="form-inline row">
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-4" name="development_reward[checked]" value="1" <?php if (!empty($development_reward_check) && $development_reward_check == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-4">发展奖励 → 奖励比例</label>
				</div>
				<input type="text" name="development_reward[rate]" onchange="this.value=fomatFloat(this.value,1,0)" style="width:70px;height: 26px;" value="<?= empty($development_reward_ratio) ? '' : $development_reward_ratio; ?>"
					   class="form-control" title="请输入发展奖励比例"/> %
			</div>

			<div class="form-inline row">
				<div class="checkbox checkbox-info checkbox-inline">
					<input type="checkbox" id="checkbox-package-5" name="point_award[checked]" value="1" <?php if (!empty($point_award_check) && $point_award_check == 1) { ?> checked<?php } ?>/>
					<label for="checkbox-package-5">见点奖励 → 奖励比例</label>
				</div>
				<input type="text" name="point_award[rate]" onchange="this.value=fomatFloat(this.value,1,0)" style="width:70px;height: 26px;" value="<?= empty($point_award_ratio) ? '' : $point_award_ratio; ?>"
					   class="form-control" title="请输入见点奖比例"/> %
				<p class="form-control-static">有效层级</p>
				<input type="text" name="effective_hierarchy" style="width:70px;height: 26px;" value="<?= empty($effective_hierarchy) ? '' : $effective_hierarchy; ?>"
					   class="form-control" onchange="this.value=isInt(this.value)" title="请输入有效层级"/> 层
			</div>

		</div>

	</div>
        
<!--        <div class="form-group form-inline">
        <label class="col-sm-2 control-label"><b class="text-danger">*</b> 钱包抵用配套(多选)</label>
        <div class="col-sm-10 row form-inline">
                
                    <div class="form-inine">
                            <div class="checkbox checkbox-info checkbox-inline">
                                <input type="checkbox" id="checkbox-wallet-6" name="company_score[checked]" value="1" <?php if (!empty($company_score_check) && $company_score_check == 1) { ?> checked<?php } ?>/>
                                <label for="checkbox-wallet-6">公司分 →最多抵配套</label>
                            </div>
                            <input type="text" name="company_score[rate]" onchange="this.value=fomatFloat(this.value)" style="width: 70px;height: 26px;" value="<?= empty($company_score_ratio) ? '' : $company_score_ratio; ?>"
                                   class="form-control" title="请输入公司分比例"/>%
                        </div>
                    
                    <div class="form-inine">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-wallet-7" name="cash_score[checked]" value="1" <?php if (!empty($cash_score_check) && $cash_score_check == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-wallet-7">现金分 →最多抵配套</label>
                        </div>
                        <input type="text" name="cash_score[rate]" onchange="this.value=fomatFloat(this.value)" style="width:70px;height: 26px;" value="<?= empty($cash_score_ratio) ? '' : $cash_score_ratio; ?>"
                               class="form-control" title="请输入现金分比例"/>%
                    </div>
                    
                    <div class="form-inine">
                        <div class="checkbox checkbox-info checkbox-inline">
                            <input type="checkbox" id="checkbox-wallet-8" name="entertainment_score[checked]" value="1" <?php if (!empty($entertainment_score_check) && $entertainment_score_check == 1) { ?> checked<?php } ?>/>
                            <label for="checkbox-wallet-8">娱乐分 →最多抵配套</label>
                        </div>
                        <input type="text" name="entertainment_score[rate]" onchange="this.value=fomatFloat(this.value)" style="width:70px;height: 26px;" value="<?= empty($entertainment_score_ratio) ? '' : $entertainment_score_ratio; ?>"
                               class="form-control" title="请输入娱乐分比例"/>%
                    </div>
                </div>
    </div>-->

    <div class="form-group">
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> 配套描述</label>
			<div>
				<textarea name="package_description" title="请输入配套描述" required="" class="form-control" rows="3"><?= empty($package_description) ? '' : $package_description; ?></textarea>
			</div>
		</div>
		<div class="col-lg-6">
			<label><b class="text-danger">*</b> Description</label>
			<div>
				<textarea name="package_description_en" title="请输入配套描述" required="" class="form-control" rows="3"><?= empty($package_description_en) ? '' : $package_description_en; ?></textarea>
			</div>
		</div>
    </div>

    <div class="form-group">
		<div class="col-sm-12">
			<label><b class="text-danger">*</b> 详细介绍（中文）</label>
			<div>
				<textarea data-description name="package_detail" title="请输入详细介绍" required="" style="width: 100%;height:300px;"><?= empty($package_detail) ? '' : $package_detail; ?></textarea>
			</div>
		</div>
    </div>
    <div class="form-group">
		<div class="col-lg-12">
			<label><b class="text-danger">*</b> 详细介绍（英文）</label>
			<div>
				<textarea data-description name="package_detail_en" title="请输入详细介绍" required="" style="width: 100%;height:300px;"><?= empty($package_detail_en) ? '' : $package_detail_en; ?></textarea>
			</div>
		</div>
    </div>
    
    <?php if (!empty($id)) { ?>
    <div class="form-group">
		<div class="col-lg-12">
			<label>创建时间</label>
			<div>
				<p class="form-control-static"><?= empty($create_time) ? '' : date('Y-m-d H:i:s', $create_time); ?></p>
			</div>
		</div>
    </div>
	<input type="hidden" name="id" value="<?= !empty($id) ? $id : 0; ?>"/>
<?php } ?>
</form>

<script>
$('[data-description]').createEditor();
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
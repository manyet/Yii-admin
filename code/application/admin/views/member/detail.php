<?php $this->beginBlock('title') ?>用户列表 > 详细资料<?php $this->endBlock() ?>

<?php $this->beginBlock('tool') ?>
<button type="button" class="btn btn-xs btn-default" onclick="$.page.back()">返回上一页</button>
<?php $this->endBlock() ?>

<?php $this->beginBlock('content') ?>
<style type="text/css">
.bg-ddd{background:#f4f4f4; color:#444}
.user-btn{height:100%; position:absolute; right:0; top:0;}
.table .f-pr{position:relative}
.table td{border-color: #ddd !important}
</style>
<div class="row">
  <div class="col-lg-6">
	  <h4>个人资料</h4>
	  <table class="table text-center table-bordered">
		  <tbody>
			  <tr>
				  <td class="col-xs-4 bg-ddd">玩家账户</td>
				  <td class="col-xs-8"><?= $uname ?></td>        
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">玩家昵称</td>
				  <td class="col-xs-8"><?= $nickname ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">真实姓名</td>
				  <td class="col-xs-8"><?= $realname == '' ? '/' : $realname ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">性别</td>
				  <td class="col-xs-8"><?php
				  if ($gender == 1) {
					  echo '男';
				  } else if ($gender == 2) {
					  echo '女';
				  } else {
					  echo '/';
				  }
				  ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">身份</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= getUserIdentity($identity) ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn" data-modal="<?=\yii\helpers\Url::toRoute('identity')?>?id=<?=$id?>">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">生日</td>
				  <td class="col-xs-8"><?= $birthday == '' ? '/' : $birthday ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">手机号码</td>
				  <td class="col-xs-8"><?= $mobile == '' ? '/' : $mobile ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">安全邮箱</td>
				  <td class="col-xs-8"><?= $email ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">注册时间</td>
				  <td class="col-xs-8"><?= date('Y-m-d H:i:s') ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">邀请码</td>
				  <td class="col-xs-8"><?= $invite_code ?></td>
			  </tr>
		  </tbody>
	  </table>
  </div>
  <div class="col-lg-6">
	  <h4>推广数据</h4>
	  <table class="table text-center table-bordered">
		  <tbody>
			  <tr>
				  <td class="col-xs-4 bg-ddd">直推总人数</td>
				  <td class="col-xs-8"><?= $promote_count ?></td>        
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">发展区总人数</td>
				  <td class="col-xs-8"><?= $total_count ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">发展区总业绩</td>
				  <td class="col-xs-8"><?= number_format($total_achievement, 2) ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">发展区层级数</td>
				  <td class="col-xs-8"><?= $max_level ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">累计直推奖励</td>
				  <td class="col-xs-8"><?= number_format($total_direct_reward, 2) ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">累计发展奖励</td>
				  <td class="col-xs-8"><?= number_format($total_indirect_reward, 2) ?></td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">累计见点奖励</td>
				  <td class="col-xs-8"><?= number_format($total_point_reward, 2) ?></td>
			  </tr>
		  </tbody>
	  </table>
  </div>
</div>
<div class="row">
  <div class="col-lg-6">
	  <h4>莫斯钱包</h4>
	  <table class="table text-center table-bordered">
		  <tbody>
			  <tr>
				  <td class="col-xs-4 bg-ddd">公司分</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= number_format($company_integral, 2) ?></span>
                      <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('company')?>?id=<?=$id?>">调整</button>
                  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">现金分</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= number_format($cash_integral, 2) ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('trim')?>?id=<?=$id?>&type=2">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">娱乐分</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= number_format($entertainment_integral, 2) ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('trim')?>?id=<?=$id?>&type=3">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">公司分红</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= number_format($total_dividend_reward, 2) ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('trim')?>?id=<?=$id?>&type=5">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">分红电子分</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= number_format($electronic_number, 2) ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('trim')?>?id=<?=$id?>&type=6">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">电子分余额</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= number_format($froze_electronic_number, 2) ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('trim')?>?id=<?=$id?>&type=7">调整</button>
				  </td>
			  </tr>
		  </tbody>
	  </table>
  </div>
  <div class="col-lg-6">
	  <h4>配套业务</h4>
	  <table class="table text-center table-bordered">
		  <tbody>
			  <tr>
				  <td class="col-xs-4 bg-ddd">配套等级</td>
				  <td class="col-xs-8"><?= $rank_name ?></td>        
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">每日分红</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= $daily_dividend_ratio == '' ? '/' : $daily_dividend_ratio . '%' ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('assort')?>?id=<?=$id?>&type=1">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">任务收益</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= $task_benefit_ratio == '' ? '/' : $task_benefit_ratio . '%' ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('assort')?>?id=<?=$id?>&type=2">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">直推奖励</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= $direct_reward_ratio == '' ? '/' : $direct_reward_ratio . '%' ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('assort')?>?id=<?=$id?>&type=3">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">发展奖励</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= $development_reward_ratio == '' ? '/' : $development_reward_ratio . '%' ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('assort')?>?id=<?=$id?>&type=4">调整</button>
				  </td>
			  </tr>
			  <tr>
				  <td class="col-xs-4 bg-ddd">见点奖</td>
				  <td class="col-xs-8 f-pr">
					  <span><?= $point_award_ratio == '' ? '/' : $point_award_ratio . '%' ?></span>
					  <button class="pull-right btn btn-primary btn-flat user-btn"
                              data-modal="<?=\yii\helpers\Url::toRoute('assort')?>?id=<?=$id?>&type=5">调整</button>
				  </td>
			  </tr>
		  </tbody>
	  </table>
  </div>
</div>
<?php $this->endBlock() ?>
<?php /* @var $this \yii\web\View */ ?>
<?php $this->beginBlock('title'); ?>公众号配置<?php $this->endBlock() ?>

<?php $this->beginBlock('body'); ?>
<div class="form-group">
	<label class="col-lg-3 control-label"><b class="text-danger">*</b> 名称</label>
	<div class="col-lg-9">
		<input type="text" name="name" autofocus required value="<?= empty($name) ? '' : $name; ?>" title="请输入公众号名称" placeholder="请输入公众号名称（必填）" class="form-control">
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label"><b class="text-danger">*</b> AppId<br/>(应用ID)</label>
	<div class="col-lg-9">
		<input type="text" name="appid" required value="<?= empty($appid) ? '' : $appid; ?>" title="请输入公众号AppId" placeholder="请输入公众号AppId（必填）" class="form-control">
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label"><b class="text-danger">*</b> AppSecret<br/>(应用密钥)</label>
	<div class="col-lg-9">
		<input type="text" name="appsecret" required value="<?= empty($appsecret) ? '' : $appsecret; ?>" title="请输入公众号AppSecret" placeholder="请输入公众号AppSecret（必填）" class="form-control">
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label"><b class="text-danger">*</b> Token<br/>(令牌)</label>
	<div class="col-lg-9">
		<input type="text" name="token" required value="<?= empty($token) ? '' : $token; ?>" title="请输入接口认证Token" placeholder="请输入接口认证Token（必填）" class="form-control">
		<span class="help-block margin-bottom-none">必须为英文或数字，长度为3-32字符。</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">EncodingAESKey<br/>(消息加解密密钥)</label>
	<div class="col-lg-9">
		<input type="text" name="encodingaeskey" value="<?= empty($encodingaeskey) ? '' : $encodingaeskey; ?>" pattern="^[A-Za-z0-9]{43}$" title="请输入43位消息加密密钥" placeholder="开启了消息加密时必需填写（可选）" class="form-control">
		<span class="help-block margin-bottom-none">由43位字符组成，可随机修改，字符范围为A-Z，a-z，0-9。</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label"><b class="text-danger">*</b> 类型</label>
	<div class="col-lg-9">
		<select name="type" required title="请选择公众号类型" class="form-control">
			<option value="">请选择公众号类型</option>
			<?php
			$types = common\services\WechatConfigService::getType();
			foreach ($types as $key => $type_name) {
			?>
			<option value="<?= $key ?>"<?php if (isset($type) && $key == $type) {?> selected<?php } ?>><?= $type_name ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">引导关注页面链接</label>
	<div class="col-lg-9">
		<input type="text" name="subscribe_url" value="<?= empty($subscribe_url) ? '' : $subscribe_url; ?>" title="请输入引导关注页面链接" placeholder="请输入引导关注页面链接" class="form-control">
		<span class="help-block margin-bottom-none">必须为英文或数字，长度为3-32字符。</span>
	</div>
</div>

<?php if (!empty($id)) { ?>
<input type="hidden" name="id" value="<?= $id ?>"/>
<?php } ?>
<?php $this->endBlock() ?>
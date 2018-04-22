<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="<?= get_img_url() ?>favicon.ico" type="img/x-icon">
  <title><?= get_system_config('WEB_ADMIN_TITLE') ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= get_platform_url() ?>css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?= get_platform_url() ?>js/html5shiv.min.js"></script>
  <script src="<?= get_platform_url() ?>js/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css">
  <link rel="stylesheet" href="<?= get_css_url() ?>animate.css">
  <link rel="stylesheet" href="<?= get_css_url() ?>mine.css">
  <style>#validate-code img{border:1px solid #d2d6de;width:100%;height:34px;cursor:pointer}</style>
</head>
<body class="hold-transition login-page" style="padding-top:1px">
<div class="login-box animated fadeInDown">
  <div class="login-logo">
    <a href="<?= \Yii::$app->homeUrl ?>"><?= get_system_config('WEB_ADMIN_TITLE') ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">请登录系统</p>

    <form name="login" action="<?= \yii\helpers\Url::toRoute(['do-login', 'redirectURL' => \Yii::$app->request->get('redirectURL')]) ?>" method="post" data-validate data-ajax data-error-element="#errMsg" onsubmit="return false;">
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
		<input type="text" class="form-control" name="username" placeholder="用户名" title="请输入用户名" required<?php if(isset($_COOKIE['uk']) && $_COOKIE['uk'] != '') { ?> value="<?= $_COOKIE['uk'] ?>"<?php } ?>/>
		<div id="errMsg" class="single-error"></div>
      </div>
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<input type="password" class="form-control" name="password" placeholder="密码" pattern="^[A-Za-z0-9]{6,20}$" title="密码为6~16位的字符" required/>
      </div>
	  <div class="row" id="validate-code"<?php if ($error_times < 3) { ?> style="display:none"<?php } ?>>
        <div class="col-xs-8" style="padding-right:0">
	      <div class="form-group">
	        <input type="text" class="form-control" name="vcode" placeholder="验证码" title="请输入验证码" required/>
        </div>
        </div>
		<div class="col-xs-4"><?= \yii\captcha\Captcha::widget(['name'=>'captchaimg','captchaAction'=>'captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'图形验证码'],'template'=>'{image}']) ?></div>
	  </div>
      <div class="row" style="margin-bottom: 15px">
        <div class="col-xs-8">
		  <div class="checkbox checkbox-primary" style="margin:0">
			<input id="remember" type="checkbox" name="remember"/>
			<label for="remember">记住用户名</label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4 text-right"><a href="javascript:;" onclick="$.msg.toast('请联系系统管理员')">忘记密码</a>
          
        </div>
        <!-- /.col -->
      </div>
	  <button type="submit" class="btn btn-primary btn-block btn-flat" data-loading-text="验证账号密码">登 录</button>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?= get_plugin_url() ?>jQuery/jquery-2.2.3.min.js"></script>
<!-- Mainly scripts -->
<?= \admin\widgets\IndexJs::widget() ?>
<script src="<?= get_plugin_url() ?>require/require.js"></script>
<script src="<?= get_js_url() ?>config.js"></script>
<script>var et=<?= $error_times ?>;</script>
<script src="<?= get_js_url() ?>login.js"></script>
<script src="<?= get_js_url() ?>animate-bg.js"></script>
</body>
</html>
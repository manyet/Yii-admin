<?php use yii\helpers\Html; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
  <link rel="stylesheet" href="<?= get_css_url() ?>animate.css">
  <style>label.error{color:#cc5965;display:block;margin-left:5px}.form-control.error{border:1px dotted #cc5965}</style>
</head>
<body class="sidebar-mini">
	<section class="content">

      <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> 出错了！</h3>

          <p>
			<h2><?= nl2br(Html::encode($message)) ?></h2>
            你可以 <a href="<?= \yii\helpers\Url::home() ?>">返回首页</a> 或 <a href="javascript:history.back();">返回上一页</a>
			<p class="f-fs14 fc-999 f-mt5">页面 <span id="wait" class="fc-f40"><?= empty($waitSecond) ? '3' : $waitSecond ?></span> 秒后自动 <a id="href" class="fc-0e6a99" href="<?= empty($jumpUrl) ? 'javascript:history.back();' : $jumpUrl ?>">跳转</a></p>
          </p>

          <!--<form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </form>-->
        </div>
      </div>
      <!-- /.error-page -->

    </section>

<script type="text/javascript">
(function(){
var wait = document.getElementById('wait');
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		document.getElementById('href').click();
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
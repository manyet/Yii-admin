<?php
/* @var $this \yii\web\View */

echo getCommonJs();

// 样式区块
if (isset($this->blocks['script'])) {
	echo $this->blocks['script'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>微信预览</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <!--<link rel="stylesheet" href="<?= get_platform_url() ?>css/AdminLTE.min.css">-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?= get_platform_url() ?>js/html5shiv.min.js"></script>
  <script src="<?= get_platform_url() ?>js/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="<?= get_css_url() ?>wechat.css">
</head>
<body class="wechat-body">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper1">
    <!-- Main content -->
    <section class="content1">

      <!-- Direct Chat -->
          <!-- DIRECT CHAT PRIMARY -->
          <?= $content ?>
          <!--/.direct-chat -->
        <!-- /.col -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
</body>
</html>
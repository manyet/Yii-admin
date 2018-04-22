<?php
$this->title = $message;
?>
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
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="<?= \yii\helpers\Url::home() ?>">return to index</a><!-- or try using the search form.-->
          </p>

          <!--<form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </form>-->
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
</body>
</html>
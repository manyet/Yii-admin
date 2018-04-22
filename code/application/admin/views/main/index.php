<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="<?= get_img_url() ?>favicon.ico" type="img/x-icon">
  <title><?= get_system_config('WEB_ADMIN_TITLE') ?> - 管理后台</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= get_platform_url() ?>css/skins/skin-<?= get_system_config('COLOR_STYLE') ?>.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>pace/pace.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?= get_platform_url() ?>js/html5shiv.min.js"></script>
  <script src="<?= get_platform_url() ?>js/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="<?= get_plugin_url() ?>awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css">
  <link rel="stylesheet" href="<?= get_css_url() ?>animate.css">
  <link rel="stylesheet" href="<?= get_css_url() ?>mine.css">
</head>
<body class="sidebar-mini skin-<?= get_system_config('COLOR_STYLE') ?><?php if (!get_system_config('FULL_SCREEN')) { ?> layout-boxed<?php } else { ?> fixed<?php } ?>">
<!-- Site wrapper -->
<div class="wrapper" style="overflow:hidden">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?= \Yii::$app->homeUrl ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>M</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?= get_system_config('WEB_ADMIN_TITLE') ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle navbar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
        <i class="fa fa-angle-down"></i>
      </button>
	  <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul id="top-menu" class="nav navbar-nav">
			<?php
			foreach($menus as $one) {
			?>
			<li data-menu-spm="<?= $one['id'] ?>"><a href="javascript:;"><?php if (isset($one['icon']) && $one['icon'] !== '') { ?><i class="<?= $one['icon'] ?>"></i> <?php } ?><?= $one['name'] ?></a></li>
			<?php } ?>
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
          <!--<form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form>-->
        </div>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		  <li>
            <a href="javascript:;" onclick="$.page.reload()" title="刷新">
              <i class="glyphicon glyphicon-refresh"></i>
			</a>
		  </li>
		  <?php if (FALSE) { ?>
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?= get_img_url() ?>lazy.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
		  <?php } ?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= get_img_url() ?>lazy.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= session('user.realname') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= get_img_url() ?>lazy.png" class="img-circle" alt="User Image">

                <p>
                  <?= session('user.realname') ?><!-- - 用户角色-->
                  <small>加入时间：<?= date('Y-m-d H:i:s', session('user.create_time')) ?></small>
                </p>
              </li>
              <!-- Menu Body
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="javascript:;" data-modal="<?= \yii\helpers\Url::toRoute('user/my-pwd') ?>" class="btn btn-default btn-flat">修改密码</a>
                </div>
                <div class="pull-right">
                  <a href="javascript:;" data-logout="<?= \yii\helpers\Url::toRoute('logout') ?>" class="btn btn-default btn-flat">退出</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img style="cursor:pointer;min-height:45px" data-modal="<?= \yii\helpers\Url::toRoute('user/my-info') ?>" src="<?= get_img_url() ?>lazy.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= session('user.realname') ?></p>
          <a><i class="fa fa-circle text-success"></i> 在线</a>
        </div>
      </div>
      <!-- search form
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
	  <?= $sidebar ?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="page-container">
    <!-- Content Header (Page header)
    <section class="content-header">
      <h1>
        Pace page
        <small>Loading example</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Pace page</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content"><div class="loading"></div></section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> <?= get_system_config('SYSTEM_VERSION') ?>
    </div>
    <strong>Copyright &copy; <?= get_system_config('WEB_SITE_COPYRIGHT_YEAR') ?> <a target="_blank" href="<?= get_system_config('WEB_SITE_COPYRIGHT_LINK') ?>"><?= get_system_config('WEB_SITE_COPYRIGHT') ?></a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?= get_plugin_url() ?>jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= get_plugin_url() ?>bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?= get_plugin_url() ?>slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick
<script src="<?= get_plugin_url() ?>fastclick/fastclick.js"></script> -->
<!-- AdminLTE App -->
<script src="<?= get_platform_url() ?>js/app.min.js"></script>
<script>
<?php $avatar = session('user.avatar'); ?>
$('body img').attr('src','<?= $avatar ?>').on('error',function(){if(this.src!=='')this.src='<?= get_platform_url() ?>img/avatar5.png';});
window.paceOptions={startOnPageLoad:false};
$.AdminLTE.options.enableControlTreeView = false;
</script>
<!-- PACE -->
<script src="<?= get_plugin_url() ?>pace/pace.min.js"></script>
<script src="<?= get_plugin_url() ?>jQuery/jquery.cookie.js"></script>
<!-- page script -->
<script src="<?= get_plugin_url() ?>require/require.js"></script>
<script src="<?= get_plugin_url() ?>laydate/laydate.js"></script>
<script src="<?= get_js_url() ?>config.js"></script>
<script src="<?= get_js_url() ?>app.js"></script>
<?= getIndexJs() ?>
</body>
</html>
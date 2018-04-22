<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link rel="shortcut icon" href="<?= Yii::getAlias('@img') ?>/favicon.ico" type="img/x-icon">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?> - <?= get_system_config('WEB_SITE_TITLE') ?></title>
<meta name="keywords" content="<?= get_system_config('WEB_SITE_KEYWORD') ?>">
<meta name="description" content="<?= get_system_config('WEB_SITE_DESCRIPTION') ?>">
<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@css') ?>/reset.css">
<link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@css') ?>/mesweb.css">
<script type="text/javascript" src="<?= Yii::getAlias('@plug') ?>/jquery.min.js"></script>
<script>window.language={"confirm":"<?= Yii::t('app', 'confirm') ?>","cancel":"<?= Yii::t('app', 'cancel') ?>","network_error":"<?= Yii::t('app', 'network_error') ?>","loading":"<?= Yii::t('app', 'loading') ?>","nomore":"<?= Yii::t('app', 'no_more') ?>"};</script>
<?php if (isset($this->blocks['head'])) { echo $this->blocks['head']; } ?>
</head>
<body class="bg-19181d">
<?php
$this->beginBody();

if (isset($this->blocks['container'])) {
?>
<!--头部开始-->
<header class="headerBox">
	<div class="header_in f-pr">
		<?php if(isset($this->blocks['header'])) { echo $this->blocks['header']; } else { ?>
		<h2 class="f-fs16 fc-fff"><?= isset($this->params['title']) ? $this->params['title'] : $this->title ?></h2>
		<?php } ?>
    </div>
</header>
<div style="height:5rem;"></div>
<!--头部结束-->
<?= $this->blocks['container'] ?>
<?php
} else {
	echo $content;
}
if (isset($this->blocks['script'])) {
	echo $this->blocks['script'];
}
$this->endBody()
?>
</body>
</html>
<?php $this->endPage() ?>
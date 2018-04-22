<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// 基本路径定义
require(__DIR__ . '/../../../define.php');

require(SYSTEM_PATH . '/vendor/autoload.php');
require(SYSTEM_PATH . '/vendor/yiisoft/yii2/Yii.php');
require(COMMON_PATH . '/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(COMMON_PATH . '/config/main.php'),
    require(COMMON_PATH . '/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);
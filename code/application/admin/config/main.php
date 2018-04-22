<?php
$params = array_merge(
    require(COMMON_PATH . '/config/params.php'),
    require(COMMON_PATH . '/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
	'language' => 'zh-CN', // 语言
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin', //token-name
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-admin',
            'timeout' => 7200,
            'cookieParams' => ['lifetime' => 7200]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'common/error',
        ],
        'urlManager' => [
            /*'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],*/
			'suffix' => ''
        ],
    ],
	'defaultRoute' => 'main',
    'params' => $params,
];

<?php
$params = array_merge(
    require(COMMON_PATH . '/config/params.php'),
    require(COMMON_PATH . '/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'wap',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'wap\controllers',
    'components' => [
		'assetManager' => [
			'bundles' => [
				'yii\web\JqueryAsset' => [
					'js' => [],  // 去除 jquery.js
					'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
				]
			]
		],
        'request' => [
            'csrfParam' => '_csrf-wap',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-wap', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the wap
            'name' => 'advanced-frontend',
//            'timeout' => 259200,
//            'cookieParams' => ['lifetime' => 259200]
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
	'defaultRoute' => 'main',
    'params' => $params,
	'on beforeRequest' => function ($event) {
		$l_saved = Yii::$app->request->cookies->get('language');
		$l = ($l_saved) ? $l_saved->value : Yii::$app->params['systemDefaultLanguage'];

		Yii::$app->language = $l;
		return;
	}
];

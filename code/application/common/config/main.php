<?php
return [
    'timeZone' => 'Asia/Shanghai',
    'vendorPath' => SYSTEM_PATH . '/vendor',
    'components' => [
        'cache' => [
			'class' => 'yii\caching\DbCache',
			'cacheTable' => 'common_cache',
		],
        'session' => [
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'common_session', // session 数据表名
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,//这里是隐藏index.php那个路径�?
            'suffix' => '.html',
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
		'i18n' => [ 
			'translations' => [ 
				'app' => [ 
					'class' => 'yii\i18n\PhpMessageSource', 
					'basePath' => '@common/messages', 
					'sourceLanguage' => 'en', 
					'fileMap' => [
						 'app' => 'app.php', 
					],
				],
			],
		], 
    ],
    'aliases' => [
        // 自动加载类库文件
        '@library' => LIBRARY_PATH,
        '@dosamigos/qrcode' => LIBRARY_PATH . '/qrcode/src',
        '@upload' => LIBRARY_PATH . '/upload-pic',
    ],
];

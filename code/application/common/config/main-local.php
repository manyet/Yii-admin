<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=172.18.0.13;dbname=jaclub',//数据库自己建的morefun的表
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'tablePrefix' => 'new_'
        ],
        /*'log' => [
            'class'=>'CLogRouter',//文件记录日志
            'routes'=> [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'trace, info, error, warning',
                ],
                [
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace', //级别为trace
                    'categories' => 'system.db.*', //只显示关于数据库信息,包括数据库连�?数据库执行语�?
                    'logFile' => 'app_'.date('Y-m-d').'.log',//日志保存文件�?
                    'logPath'=>'D:\log_db',//日志保存路径
                ]
            ],
        ]*/
    ],
];

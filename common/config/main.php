<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=osconfig',
            'username' => 'orcsis',
            'password' => 'orc',
            'charset' => 'utf8',
        ],
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=OSEMPRESA',
            'username' => 'orcsis',
            'password' => 'orc',
            'charset' => 'utf8',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
        'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'db' => 'db',
			'itemTable' => 'osrol',
			'itemChildTable'=>'osrolhijo',
			'assignmentTable'=>'osasignarol',
			'ruleTable'=>'osreglaneg',
		],
		'i18n' => [
			'translations' => [
				'app*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => __DIR__.'/../messages/',
					'fileMap' => [
						'app' => 'app.php',
					],
				],
				'admin*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => __DIR__.'/../messages/',
					'fileMap' => [
						'admin' => 'admin.php',
					],
				],
				'yii' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'en-US',
					'basePath' => __DIR__.'/../messages/',
				],
			],
		],
		'session' => [
			'class' => 'yii\web\DbSession',
			'sessionTable' => 'ossession',
		],
		'orcsis' => [
			'class' => 'orcsis\components\Orcsis',
			'OpcTabModelClass' => 'common\models\Osopctab',
		],
    ],
];

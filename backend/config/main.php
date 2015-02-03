<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
	'language' => 'es-VE',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Osusuarios',
            //'enableAutoLogin' => true,
            'enableSession'=> false,
        	'loginUrl' => null,
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
        /*'errorHandler' => [
            'errorAction' => 'site/error',
        ],*/
    	'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'soylaclavequesenecesita',
    		'enableCookieValidation' => false,
        ],
    'urlManager' => [
    	'enablePrettyUrl' => true,
    	'enableStrictParsing' => false,
    	'showScriptName' => false,
    	'rules' => [
        	['class' => 'yii\rest\UrlRule',
        	 'controller' => 'user',
        	 'extraPatterns' => [
        						'POST login' => 'login',
				],
        	],
    	],
	]
    ],
	'as access' => [
		'class' => 'orcsis\admin\components\AccessControl',
		'allowActions' => [
			'debug/*',
			'site/login',
			'site/logout',
			'user/login', // add or remove allowed actions to this list
		]
	],
    'params' => $params,
];

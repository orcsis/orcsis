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
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
    'urlManager' => [
    	'enablePrettyUrl' => true,
    	'enableStrictParsing' => false,
    	'showScriptName' => false,
    	'rules' => [
        	['class' => 'yii\rest\UrlRule',
        	 'controller' => ['login','osempresa'],
             //'except' => ['delete', 'create', 'update','optios','index'],
        	 'extraPatterns' => [
        						'POST login' => 'login',
				],
        	],
    	],
	]
    ],
    'as authenticator' => [
        'class' => 'orcsis\components\HttpAuth',
        'allowActions' => [
            'debug/*',
            'login/*',
        ]
    ],
	'as access' => [
		'class' => 'orcsis\admin\components\AccessControl',
		'allowActions' => [
			'debug/*',
			'login/*',
            'login/logout', // add or remove allowed actions to this list
		]
	],
    'as corsFilter' => [
        'class' => 'yii\filters\Cors',
    ],
    'params' => $params,
];

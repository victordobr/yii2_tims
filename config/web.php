<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'auth' => [
            'class' => 'app\modules\auth\Module',
            'userModelClass' => 'app\models\User'
        ],
    ],
    'components' => [
        'auth' => [
            'class' => 'app\components\Auth',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3ao-RPi_7do6nBs85xndY-FwFezZEx7b',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\modules\auth\models\mappers\classes\UserIdentity',
            'enableAutoLogin' => true,
            'loginUrl'        => '/auth/default/login',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => '/',
                    'route'   => 'auth/default/login'
                ],
                [
                    'pattern' => 'login',
                    'route' => 'auth/default/login'
                ],
                [
                    'pattern' => 'logout',
                    'route'   => 'auth/default/logout'
                ],
                [
                    'pattern' => '<controller:\w+>/<action:[\w-]+>/<id:\d+>',
                    'route' => '<controller>/<action>',
                ],
                [
                    'pattern' => '<controller:\w+>/<action:[\w-]+>',
                    'route' => '<controller>/<action>',
                ],
                [
                    'pattern' => '<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>',
                    'route' => '<module>/<controller>/<action>',
                ],
                [
                    'pattern' => '<module:\w+>/<controller:\w+>/<action:[\w-]+>',
                    'route' => '<module>/<controller>/<action>',
                ],
            ],
        ],
        'db' => YII_DEBUG ? require(__DIR__ . '/local/db.php') : require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

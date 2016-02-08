<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['eventManager', 'log'],
    'modules' => [
        'auth' => [
            'class' => 'app\modules\auth\Module',
            'userModelClass' => 'app\models\User'
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'frontend' => [
            'class' => 'app\modules\frontend\Module',
        ],
        'settings' => [
            'class' => 'pheme\settings\Module',
            'sourceLanguage' => 'en'
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'dynagrid' =>  [
            'class' => 'kartik\dynagrid\Module'
        ]
    ],
    'components' => [
        'eventManager' => [
            'class' => 'yiicod\listener\components\EventManager'
        ],
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyB0SyBMwxZe_M5nLtcYXcSrt10E4HLMARc',
                        'language' => 'id',
                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],
        'settings' => [
            'class' => 'app\components\Settings'
        ],
        'record' => [
            'class' => 'app\components\Record',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
//        'rbacUser' => [
//            'class' => 'app\components\RbacUser',
//        ],
        'media' => [
            'class' => 'app\components\media\Media',
            'uploadRoute' => '/frontend/records/chunk-upload',
            'handleRoute' => '/frontend/records/handle',
            'dropZone' => false,
            'tmpDirectory' => '@app/web/uploads/tmp/',
            'storageDirectory' => '@app/web/uploads/storage/',
            'storageUrl' => '/uploads/storage/',
            'acceptMimeTypes'  => 'image/jpeg,image/png,image/bmp,video/avi,video/mp4,video/mpeg,video/x-flv',
            'maxFileSize' => 30000000,
            'maxChunkSize' => 2000000,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
            'itemTable' => 'AuthItem',
            'itemChildTable' => 'AuthItemChild',
            'assignmentTable' => 'AuthAssignment',
            'ruleTable' => 'AuthRule',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3ao-RPi_7do6nBs85xndY-FwFezZEx7b',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\components\RbacUser',
            'identityClass' => 'app\modules\auth\models\mappers\classes\UserIdentity',
            'enableAutoLogin' => true,
            'loginUrl' => '/auth/default/login',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.entenso.com',
                'username' => 'vdobrianskiy@entenso.com',
                'password' => 'Cfb8db8a',
                'port' => '25',
            ],
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
        'formatter'    => [
            'class'          => 'app\helpers\Formatter',
            'dateFormat'     => 'MM/dd/yy',
            'datetimeFormat' => 'MM/dd/yy HH:mm:ss',
            'booleanFormat'  => [
                '<span class="glyphicon glyphicon-remove-sign icon-failed"></span>',
                '<span class="glyphicon glyphicon-ok-sign icon-success"></span>'
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'auth/default/login',
                'login' => 'auth/default/login',
                'logout' => 'auth/default/logout',
                [
                    'pattern' => '<action:(search|review|requestDeactivation|deactivate)>/<id:\d+>',
                    'route' => 'frontend/records/<action>',
                ],
                [
                    'pattern' => '<action:(upload|chunkUpload|handle)>',
                    'route' => 'frontend/records/<action>',
                ],
                [
                    'pattern' => 'print/<action:(index|preview|qc|send|confirm|reject)>',
                    'route' => 'frontend/print/<action>',
                    'defaults' => ['action' => '']
                ],
                // admin roles
                'admin/roles' => 'admin/rbac/role/index',
                'admin/role/create' => 'admin/rbac/role/create',
                [
                    'pattern' => 'admin/role/<action:(update|view|delete)>/<name:[\w-]+>',
                    'route' => 'admin/rbac/role/<action>',
                ],
                'admin/user/profile' => 'admin/user-profile',
                [
                    'pattern' => 'admin/user-profile/<action:(profile|changePassword)>/<name:[\w-]+>',
                    'route' => 'admin/user-profile/<action>',
                    'defaults' => ['action' => '']
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

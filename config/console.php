<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = YII_DEBUG ? require(__DIR__ . '/local/db.php') : require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'user' => [
            'class' => 'app\components\RbacUser',
            'identityClass' => 'app\modules\auth\models\mappers\classes\UserIdentity',
            'enableAutoLogin' => true,
            'loginUrl' => '/auth/default/login',
        ],
        'urlManager' => [
            'scriptUrl' => 'http://tims.boloinc.com/',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'auth' => [
            'class' => 'app\components\Auth',
        ],
        'authManager'  => [
            'class'           => 'yii\rbac\DbManager',
            'defaultRoles'    => ['guest'],
            'itemTable'       => 'AuthItem',
            'itemChildTable'  => 'AuthItemChild',
            'assignmentTable' => 'AuthAssignment',
            'ruleTable'       => 'AuthRule',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];

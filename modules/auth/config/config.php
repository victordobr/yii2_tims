<?php
return [
    'components' => [
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
    ],
    'params' => [
        // list of parameters
    ],
];
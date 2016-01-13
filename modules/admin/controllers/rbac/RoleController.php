<?php namespace app\modules\admin\controllers\rbac;

use yii\filters\AccessControl;

class RoleController extends \johnitvn\rbacplus\controllers\RoleController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}
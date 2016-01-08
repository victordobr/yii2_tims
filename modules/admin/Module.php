<?php

namespace app\modules\admin;

use \Yii;
use \yii\filters\AccessControl;
use \app\interfaces\Menu as MenuInterface;

/**
 * Web module for administration panel.
 */
class Module extends \app\base\Module  implements MenuInterface
{
    /** @var string $controllerNamespace controller namespace */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['UsersMgmt'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getMenuItems()
    {
        return [
            ['label' => Yii::t('app', 'Cases'), 'url' => ['/admin/cases/manage']],
            ['label' => Yii::t('app', 'Users'), 'url' => ['/admin/users/manage']],
            ['label' => Yii::t('app', 'Vehicles'), 'url' => ['/admin/vehicle/index']],


            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app', 'Login'), 'url' => ['/login']] :
                [
                    'label'       => Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                    'url'         => ['/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ];
    }
}

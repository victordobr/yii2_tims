<?php

namespace app\modules\admin;

use app\enums\Role;
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

    public $layout = 'main.php';

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
                        'roles' => [Role::ROLE_ROOT_SUPERUSER, Role::ROLE_SYSTEM_ADMINISTRATOR],
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
            ['label' => Yii::t('app', 'Owners'), 'url' => ['/admin/owners/manage']],
            ['label' => Yii::t('app', 'Records'), 'url' => ['/admin/records/manage']],
            ['label' => Yii::t('app', 'Users'), 'url' => ['/admin/users/manage']],
            ['label' => Yii::t('app', 'Vehicles'), 'url' => ['/admin/vehicle/index']],
            ['label' => Yii::t('app', 'Statuses'), 'url' => ['/admin/case-status/index']],
            ['label' => Yii::t('app', 'Roles'), 'url' => ['/admin/roles']],
            ['label' => Yii::t('app', 'Profile'), 'url' => ['/admin/user-profile']],
            ['label' => Yii::t('app', 'Settings'), 'url' => ['/admin/settings/index']],
            ['label' => Yii::t('app', 'Questions'), 'url' => ['/admin/question/index']],
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

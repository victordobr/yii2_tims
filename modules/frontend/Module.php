<?php

namespace app\modules\frontend;

use \Yii;
use \yii\filters\AccessControl;
use \app\interfaces\Menu as MenuInterface;

/**
 * Web module for administration panel.
 */
class Module extends \app\base\Module  implements MenuInterface
{
    /** @var string $controllerNamespace controller namespace */
    public $controllerNamespace = 'app\modules\frontend\controllers';

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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getNavbarItems()
    {
        return [
            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app', 'Login'), 'url' => ['/login']] :
                ['label' => Yii::t('app', 'Profile'), 'url' => ['/profile']],
                [
                    'label'       => Yii::t('app', 'Sing Out') . ' (' . Yii::$app->user->identity->username . ')',
                    'url'         => ['/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ];
    }

    public static function getMenuItems()
    {
        return [
            ['label' => Yii::t('app', 'Upload'), 'url' => ['/frontend/media/upload']],
            ['label' => Yii::t('app', 'Review'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['label' => Yii::t('app', 'Data'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['label' => Yii::t('app', 'Search'), 'url' => ['/frontend/cases/search']],
            ['label' => Yii::t('app', 'Print'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['label' => Yii::t('app', 'Resources'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['label' => Yii::t('app', 'Reports'), 'url' => false, 'options' => ['class' => 'disabled']],
        ];
    }
}

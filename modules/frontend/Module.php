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
                ['label' => Yii::t('app', 'Profile'), 'url' => ['/frontend/default/profile']],
                [
                    'label'       => Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                    'url'         => ['/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ];
    }

    public static function getMenuItems()
    {
        return [
            ['encode' => false, 'label' => \yii\bootstrap\Html::icon('upload') . '&nbsp;&nbsp;' . Yii::t('app', 'Upload'), 'url' => ['/frontend/records/upload']],
            ['encode' => false, 'label' => \yii\bootstrap\Html::icon('search') . '&nbsp;&nbsp;' . Yii::t('app', 'Search'), 'url' => ['/frontend/records/search']],
            ['encode' => false, 'label' => \yii\bootstrap\Html::icon('eye-open') . '&nbsp;&nbsp;' . Yii::t('app', 'Review'), 'url' => ['/frontend/records/review']],
            ['encode' => false, 'label' => \yii\bootstrap\Html::icon('print') . '&nbsp;&nbsp;' . Yii::t('app', 'Print'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['encode' => false, 'label' => \yii\bootstrap\Html::icon('pencil') . '&nbsp;&nbsp;' . Yii::t('app', 'Update'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['encode' => false, 'label' => \yii\bootstrap\Html::icon('list-alt') . '&nbsp;&nbsp;' . Yii::t('app', 'Reports'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['encode' => false, 'label' => \yii\bootstrap\Html::icon('asterisk') . '&nbsp;&nbsp;' . Yii::t('app', 'Settings'), 'url' => false, 'options' => ['class' => 'disabled']],
        ];
    }
}

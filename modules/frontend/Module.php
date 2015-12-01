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
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['admin'],
//                    ],
//                ],
//            ],
//        ];
//    }

    /**
     * @inheritdoc
     */
    public static function getMenuItems()
    {
        return [
            ['label' => Yii::t('app', 'Upload'), 'url' => ['/frontend/default/upload']],
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

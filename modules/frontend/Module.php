<?php

namespace app\modules\frontend;

use app\enums\MenuTab;
use app\enums\YesNo;
use \Yii;
use \yii\filters\AccessControl;
use \app\interfaces\Menu as MenuInterface;
use yii\bootstrap\Html;
use yii\helpers\BaseUrl;

/**
 * Web module for administration panel.
 */
class Module extends \app\base\Module  implements MenuInterface
{
    /**
     * @var string current tab
     */
    private static $tab;

    /** @var string $controllerNamespace controller namespace */
    public $controllerNamespace = 'app\modules\frontend\controllers';

    public function init()
    {
        parent::init();
        $handler = new \yii\web\ErrorHandler([
            'errorAction' => '/frontend/default/error'
        ]);
        \Yii::$app->set('errorHandler', $handler);
        $handler->register();
    }

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

    /**
     * @return string
     */
    public static function getTab()
    {
        if (!self::$tab) {
            self::initCurrentTab();
        }

        return self::$tab;
    }

    /**
     * @param string $tab
     * @return bool
     */
    public static function isCurrentTab($tab)
    {
        if (!self::$tab) {
            self::initCurrentTab();
        }

        return self::$tab == $tab;
    }

    /**
     * @return string
     */
    private static function initCurrentTab()
    {
        $url = Yii::$app->request->url;

        foreach (MenuTab::getTabs() as $tab) {
            if (strpos($url, $tab) == YesNo::YES) {
                return self::$tab = $tab;
            }
        }

        return self::$tab = 'undefined';
    }

    public static function getMenuItems()
    {
        $items = [];
        foreach(Yii::$app->user->tabs as $tab){
            $items[] = [
                'encode' => false,
                'label' => Yii::t('app', '{icon} {label}', [
                        'icon' => Html::icon(MenuTab::icon($tab)),
                        'label' => MenuTab::label($tab),
                    ]),
                'url' => ['/' . $tab],
                'active' => self::isCurrentTab($tab),
            ];
        }

        return $items;
    }

}

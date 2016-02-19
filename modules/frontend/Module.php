<?php

namespace app\modules\frontend;

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

        switch (YesNo::YES) {
            case strpos($url, 'search'):
                return self::$tab = 'search';
            case strpos($url, 'review'):
                return self::$tab =  'review';
            case strpos($url, 'print'):
                return self::$tab =  'print';
            case strpos($url, 'update'):
                return self::$tab =  'update';
            case strpos($url, 'reports'):
                return self::$tab =  'reports';
            case strpos($url, 'settings'):
                return self::$tab =  'settings';
            default:
                return self::$tab =  'undefined';
        }
    }

    public static function getMenuItems()
    {
        return [
            ['encode' => false, 'label' => Html::icon('upload') . '&nbsp;&nbsp;' . Yii::t('app', 'Upload'), 'url' => ['/frontend/records/upload']],
            ['encode' => false, 'label' => Html::icon('search') . '&nbsp;&nbsp;' . Yii::t('app', 'Search'), 'url' => ['/search'], 'active' => self::isCurrentTab('search')],
            ['encode' => false, 'label' => Html::icon('eye-open') . '&nbsp;&nbsp;' . Yii::t('app', 'Review'), 'url' => ['/review'], 'active' => self::isCurrentTab('review')],
            ['encode' => false, 'label' => Html::icon('print') . '&nbsp;&nbsp;' . Yii::t('app', 'Print'), 'url' => ['/print'], 'active' =>  self::isCurrentTab('print')],
            ['encode' => false, 'label' => Html::icon('pencil') . '&nbsp;&nbsp;' . Yii::t('app', 'Update'), 'url' => ['/update'], 'active' =>  self::isCurrentTab('update')],
            ['encode' => false, 'label' => Html::icon('list-alt') . '&nbsp;&nbsp;' . Yii::t('app', 'Reports'), 'url' => false, 'options' => ['class' => 'disabled']],
            ['encode' => false, 'label' => Html::icon('asterisk') . '&nbsp;&nbsp;' . Yii::t('app', 'Settings'), 'url' => false, 'options' => ['class' => 'disabled']],
        ];
    }
}

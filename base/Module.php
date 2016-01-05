<?php
namespace app\base;

use \Yii;
use \yii\helpers\Url;

/**
 * @package app\base
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
//    public function beforeAction($action)
//    {
//        $isIgnore = false;
//        foreach (Yii::$app->params['common.ignore.backurl'] as $ignoreUrl) {
//            if (strpos(Yii::$app->request->url, $ignoreUrl) > -1) {
//                $isIgnore = true;
//                break;
//            }
//        }
//        if (!$isIgnore) {
//            Yii::$app->getUser()->setReturnUrl(Yii::$app->request->url);
//            if (Yii::$app->user->isGuest) {
//                echo Yii::$app->controller->redirect(['/', 'referrer' => Yii::$app->request->url]);
//                exit();
//            }
//        } else {
//            if (Yii::$app->user->isGuest) {
//                echo Yii::$app->controller->redirect(['/']);
//                exit();
//            }
//        }
//
//        return parent::beforeAction($action);
//    }

    /**
     * @inheritdoc
     */
    public static function getNavBarConfig()
    {
        return [
            'brandLabel' => 'My TIMS',
            'brandUrl'   => '/',
            'options'    => [
                'class' => 'navbar-inverse',
            ],
        ];
    }

    /**
     * Helper for debug
     * @param mixed $mixed
     * @param boolean $stop
     */
    public static function pa($mixed, $stop = false){
        $ar = debug_backtrace();
        $key = pathinfo($ar[0]['file']);
        $key = $key['basename'] .':'. $ar[0]['line'];
        $print = array($key => $mixed);
        echo '<pre>'. print_r($print, 1) .'</pre>';
        if ($stop == 1) exit();
    }
}

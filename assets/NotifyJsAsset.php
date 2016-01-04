<?php
namespace app\assets;

use \Yii;
use \yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files required by notifyjs plugin.
 *
 * @author Alex Makhorin
 */
class NotifyJsAsset extends AssetBundle
{
    public $sourcePath = '@bower/notifyjs';

//    public $css = [
//        'dist/css/lightbox.css',
//    ];

    public $js = [
        'dist/notify.min.js',
        'dist/styles/bootstrap/notify-bootstrap.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];
}

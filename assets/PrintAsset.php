<?php
namespace app\assets;

use \Yii;
use \yii\web\AssetBundle;


class PrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/print/style.css',
        'css/print/font.css',
        'css/print/inline.css',
    ];

    public $js = [
        'js/print.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}

<?php
namespace app\assets;

use \Yii;
use \yii\web\AssetBundle;


class PrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/print.css',
    ];

    public $js = [
        '//maps.googleapis.com/maps/api/js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

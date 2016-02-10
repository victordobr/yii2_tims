<?php
namespace app\assets;

use \Yii;
use \yii\web\AssetBundle;


class PreviewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/preview.css',
    ];

    public $js = [
        '//maps.googleapis.com/maps/api/js',
        'js/preview.js',
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
}

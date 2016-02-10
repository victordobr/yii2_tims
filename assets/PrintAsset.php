<?php
namespace app\assets;

use \Yii;
use \yii\web\AssetBundle;


class PrintAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = [
        'js/print.js',
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
}

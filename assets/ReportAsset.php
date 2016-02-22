<?php
namespace app\assets;

use \Yii;
use \yii\web\AssetBundle;

class ReportAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = [
        'js/report.js',
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
}

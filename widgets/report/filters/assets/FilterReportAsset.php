<?php
namespace app\widgets\report\filters\assets;

use \Yii;
use \yii\web\AssetBundle;

class FilterReportAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/report/filters';

    public $js = [
        'js/index.js',
    ];

    public $css = [
        'css/style.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

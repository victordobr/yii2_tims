<?php
namespace app\widgets\record\filterReport\assets;

use \Yii;
use \yii\web\AssetBundle;

class FilterReportAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/record/filterReport';

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

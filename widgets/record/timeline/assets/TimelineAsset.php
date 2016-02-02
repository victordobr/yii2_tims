<?php
namespace app\widgets\record\timeline\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

class TimelineAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/record/timeline';

    public $js = [
//        'js/index.js',
    ];

    public $css = [
        'css/style.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

<?php
namespace app\widgets\record\update\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

class UpdateButtonAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/record/update';

    public $js = [
        'js/index.js',
    ];

    public $css = [
//        'css/style.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

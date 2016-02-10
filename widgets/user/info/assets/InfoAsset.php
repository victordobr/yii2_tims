<?php

namespace app\widgets\user\info\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

class InfoAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/user/info';

    public $js = [
        'js/clock.js',
    ];
    public $css = [
        'css/style.css',
        'css/clock.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

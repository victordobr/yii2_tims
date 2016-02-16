<?php

namespace app\widgets\base\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

class GridViewAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/base';

    public $js = [
    ];
    public $css = [
        'css/grid-view.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

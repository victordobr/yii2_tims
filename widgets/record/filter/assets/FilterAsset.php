<?php
namespace app\widgets\record\filter\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

class FilterAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/record/filter';

    public $js = [
        'js/index.js',
    ];

    public $css = [];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

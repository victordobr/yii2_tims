<?php

namespace app\widgets\user\info\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

class InfoAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/widgets/user/info';

    public $js = [
        'js/clock.js',
    ];
    public $css = [
        'css/clock.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

//    public function init() {
//        $this->jsOptions['position'] = View::POS_BEGIN;
//        parent::init();
//    }
}

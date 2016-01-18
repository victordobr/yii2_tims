<?php

namespace app\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

/**
 * @package app\assets
 * @version 1.0
 */
class MapPopupAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
//    public $sourcePath = '@app/widgets/mapPopup/assets';

    public $js = [
        'http://maps.googleapis.com/maps/api/js',
    ];
//    public $css = [
//        'map.popup.css'
//    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init() {
        $this->jsOptions['position'] = View::POS_BEGIN;
        parent::init();
    }
}

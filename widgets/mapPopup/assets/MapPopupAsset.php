<?php

namespace app\widgets\mapPopup\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

/**
 * @package app\assets
 * @version 1.0
 */
class MapPopupAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/mapPopup';

    public $js = [
        '//maps.googleapis.com/maps/api/js',
    ];

    public $css = [
        'css/style.css',
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];

    public function init() {
        $this->jsOptions['position'] = View::POS_BEGIN;
        parent::init();
    }
}

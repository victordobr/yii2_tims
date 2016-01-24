<?php

namespace app\widgets\mediaPopup\assets;

use \Yii;
use \yii\web\AssetBundle;
use yii\web\View;

/**
 * @package app\assets
 * @version 1.0
 */
class MediaPopupAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        '//releases.flowplayer.org/6.0.5/flowplayer.min.js',
    ];
    public $css = [
        '//releases.flowplayer.org/6.0.5/skin/minimalist.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init() {
        $this->jsOptions['position'] = View::POS_BEGIN;
        parent::init();
    }
}

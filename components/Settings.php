<?php

namespace app\components;

use pheme\settings\components\Settings as PhemeSettings;
use Yii;

/**
 * Settings class implements the component to handle Base Site Settings operations.
 * @author Vitalii Fokov
 */
class Settings extends PhemeSettings
{
    public function get($key, $section = null, $default = null)
    {
        if(YII_ENV_PROD) {
            return parent::get($key, $section, $default);
        } else {
            return Yii::$app->params[$key];
        }
    }
}
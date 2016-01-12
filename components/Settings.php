<?php

namespace app\components;

use pheme\settings\models\Setting as PhemeSettings;
use Yii;
use app\models\File;
use yii\base\Component;

/**
 * Settings class implements the component to handle Base Site Settings operations.
 * @author Vitalii Fokov
 */

class Settings extends PhemeSettings{

    public function Settings(){

        if (defined('YII_DEBUG')){

            return Yii::$app->params['url.cabinet.admin'];
        }

        elseif(!defined('YII_DEBUG')){

            return parent::getSettings();

        }

    }

}


?>
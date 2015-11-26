<?php

namespace app\modules\auth;
use Yii;
/**
 * Auth module class.
 * @package app\modules\auth
 * @version 1.0
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
 */
class Module extends \yii\base\Module
{
    /** @var string $controllerNamespace */
    public $controllerNamespace = 'app\modules\auth\controllers';

    /** @var string $userModelClass */
    public $userModelClass;

    public function init()
    {
        parent::init();
        // initialize the module with the configuration loaded from config.php
        \Yii::configure($this, require(__DIR__ . '/config/config.php'));
    }
}

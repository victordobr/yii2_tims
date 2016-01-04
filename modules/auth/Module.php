<?php

namespace app\modules\auth;
use Yii;

use \yii\base\InvalidConfigException;
use \yii\rbac\DbManager;
/**
 * Auth module class.
 * @package app\modules\auth
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

        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component of this Yii2 application to use this module.');
        }

        // initialize the module with the configuration loaded from config.php
        \Yii::configure($this, require(__DIR__ . '/config/config.php'));
    }
}

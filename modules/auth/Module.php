<?php

namespace app\modules\auth;

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
}

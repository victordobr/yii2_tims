<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * Role Enum
 * @package app\enums
 * @version 1.0
 * @author Alex Makhorin
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
 */
class Role extends Enum
{
    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';
}

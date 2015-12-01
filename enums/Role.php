<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * Role Enum
 * @package app\enums
 * @author Alex Makhorin
 */
class Role extends Enum
{
    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';
}

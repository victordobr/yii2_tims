<?php
namespace app\enums;

use \Yii;
use app\models\User;
use \kfosoft\base\Enum;

/**
 * UserType Enum
 * @package app\enums
 */
class CaseStatus extends Enum
{
    const INCOMPLETE = 1010;
    const COMPLETE = 1020;
    const FULL_COMPLETE = 1021;

    public static function getByUserRole()
    {
        switch (true) {
            case User::hasRole(Role::ROLE_VIDEO_ANALYST):
                return [self::INCOMPLETE, self::COMPLETE, self::FULL_COMPLETE];
            case User::hasRole(Role::ROLE_VIDEO_ANALYST_SUPERVISOR):
                return [self::COMPLETE, self::FULL_COMPLETE];
            default:
                return [];
        }
    }

}
<?php
namespace app\enums;

use Yii;
use kfosoft\base\Enum;

/**
 * Log Event Enum
 * @package app\enums
 */
class LogEvent extends Enum
{
    const EVENT_LOGIN = 'login';
    const EVENT_LOGOUT = 'logout';

    public static function listData()
    {
        return [
            self::EVENT_LOGIN => Yii::t('app', 'User login'),
            self::EVENT_LOGOUT => Yii::t('app', 'User logout'),
        ];
    }
}
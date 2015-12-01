<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * UserType Enum
 * @package app\enums
 */
class UserType extends Enum
{
    const ADMIN = '1';
    const CLIENT = '2';

    /**
     * List data.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::ADMIN  => Yii::t('app', 'Administrator'),
            self::CLIENT => Yii::t('app', 'Client'),
        ];
    }

    public static function roleData()
    {
        return [
            self::ADMIN  => 'admin',
            self::CLIENT => 'client',
        ];
    }
}

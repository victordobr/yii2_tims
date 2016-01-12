<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * Basic color names in Enum
 * @package app\enums
 */
class VehicleColors extends Enum
{
    const WHITE = 0;
    const YELLOW = 1;
    const FUCHSIA = 2;
    const RED = 3;
    const SILVER = 4;
    const GRAY = 5;
    const OLIVE = 6;
    const PURPLE = 7;
    const MAROON = 8;
    const AQUA = 9;
    const LIME = 10;
    const TEAL = 11;
    const GREEN = 12;
    const BLUE = 13;
    const NAVY = 14;
    const BLACK = 15;

    /**
     * List of color names.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::WHITE  => Yii::t('app', 'White'),
            self::YELLOW  => Yii::t('app', 'Yellow'),
            self::FUCHSIA  => Yii::t('app', 'Fuchsia'),
            self::RED  => Yii::t('app', 'Red'),
            self::SILVER  => Yii::t('app', 'Silver'),
            self::GRAY  => Yii::t('app', 'Gray'),
            self::OLIVE  => Yii::t('app', 'Olive'),
            self::PURPLE  => Yii::t('app', 'Purple'),
            self::MAROON  => Yii::t('app', 'Maroon'),
            self::AQUA  => Yii::t('app', 'Aqua'),
            self::LIME  => Yii::t('app', 'Lime'),
            self::TEAL  => Yii::t('app', 'Teal'),
            self::GREEN  => Yii::t('app', 'Green'),
            self::BLUE  => Yii::t('app', 'Blue'),
            self::NAVY  => Yii::t('app', 'Navy'),
            self::BLACK  => Yii::t('app', 'Black'),
        ];
    }
}
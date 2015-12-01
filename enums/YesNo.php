<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * YesNo Enum
 * @package app\enums
 */
class YesNo extends Enum
{
    const YES = '1';
    const NO = '0';

    /**
     * List data.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::YES => Yii::t('app', 'Yes'),
            self::NO  => Yii::t('app', 'No'),
        ];
    }

    /**
     * List icons for gridview.
     * @return array|null data.
     */
    public static function listIcon()
    {
        return [
            self::NO => '<span class="glyphicon glyphicon-remove-sign icon-failed"></span>',
            self::YES => '<span class="glyphicon glyphicon-ok-sign icon-success"></span>'
        ];
    }
}

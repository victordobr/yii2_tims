<?php
namespace app\enums;

use Yii;
use kfosoft\base\Enum;

/**
 * Record actions Enum
 *
 * @package app\enums
 */
class MenuTab extends Enum
{
    const TAB_UPLOAD = 'upload';
    const TAB_SEARCH = 'search';
    const TAB_REVIEW = 'review';
    const TAB_PRINT = 'print';
    const TAB_UPDATE = 'update';
    const TAB_REPORTS = 'reports';
    const TAB_SETTINGS = 'settings';

    public static function getTabList()
    {
        return [
            self::TAB_UPLOAD => Yii::t('app', 'Upload'),
            self::TAB_SEARCH => Yii::t('app', 'Search'),
            self::TAB_REVIEW => Yii::t('app', 'Review'),
            self::TAB_PRINT => Yii::t('app', 'Print'),
            self::TAB_UPDATE => Yii::t('app', 'Update'),
            self::TAB_REPORTS => Yii::t('app', 'Reports'),
            self::TAB_SETTINGS => Yii::t('app', 'Settings'),
        ];
    }

    public static function getTabs()
    {
        return (new \ReflectionClass(__CLASS__))->getConstants();
    }

}
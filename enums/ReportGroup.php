<?php

namespace app\enums;

use Yii;

/**
 * ReportGroup Enum
 * @package app\enums
 */
class ReportGroup extends \kfosoft\base\Enum
{
    const GROUP_DAY = 1;
    const GROUP_BUS_NUMBER = 2;
    const GROUP_VIDEO_ANALYST = 3;
    const GROUP_POLICE_OFFICER  = 4;
    const GROUP_PRINT_OPERATOR = 5;

    public static function listData()
    {
        return [
            self::GROUP_DAY => Yii::t('app', 'Day'),
            self::GROUP_BUS_NUMBER => Yii::t('app', 'Bus Number'),
            self::GROUP_VIDEO_ANALYST => Yii::t('app', 'Video Analyst'),
            self::GROUP_POLICE_OFFICER => Yii::t('app', 'Police Officer'),
            self::GROUP_PRINT_OPERATOR => Yii::t('app', 'Print Operator'),
        ];
    }

    public static function listUrl()
    {
        return [
            self::GROUP_DAY => 'violations-by-date',
            self::GROUP_BUS_NUMBER => 'violations-by-school-bus',
            self::GROUP_VIDEO_ANALYST => 'violations-by-video-analyst',
            self::GROUP_POLICE_OFFICER => 'violations-by-police-officer',
            self::GROUP_PRINT_OPERATOR => 'violations-by-print-operator',
        ];
    }

    public static function listGroupAttribute()
    {
        return [
            self::GROUP_DAY => 'created_at',
            self::GROUP_BUS_NUMBER => 'bus_number',
            self::GROUP_VIDEO_ANALYST => 'VideoAnalyst',
            self::GROUP_POLICE_OFFICER => 'PoliceOfficer',
            self::GROUP_PRINT_OPERATOR => 'PrintOperator',
        ];
    }

    public static function getUrlById($id)
    {
        return self::listUrl()[$id];
    }

    public static function getIdByUrl($url)
    {
        return array_search($url, self::listUrl());
    }

    public static function getGroupAttribute($id)
    {
        return self::listGroupAttribute()[$id];
    }

    public static function getGroupTableAttribute($id)
    {
        switch(true) {
            case in_array($id, [self::GROUP_DAY, self::GROUP_BUS_NUMBER]):
                return self::listGroupAttribute()[$id];
            case in_array($id, [self::GROUP_VIDEO_ANALYST, self::GROUP_POLICE_OFFICER, self::GROUP_PRINT_OPERATOR]):
                return 'author';
        }
    }
}
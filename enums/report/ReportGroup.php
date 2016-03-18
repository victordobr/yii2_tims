<?php

namespace app\enums\report;

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

    public static function listUrlSummary()
    {
        return [
            self::GROUP_DAY => 'violations-by-date',
            self::GROUP_BUS_NUMBER => 'violations-by-school-bus',
            self::GROUP_VIDEO_ANALYST => 'violations-by-video-analyst',
            self::GROUP_POLICE_OFFICER => 'violations-by-police-officer',
            self::GROUP_PRINT_OPERATOR => 'violations-by-print-operator',
        ];
    }

    public static function listUrlDetail()
    {
        return [
            self::GROUP_BUS_NUMBER => 'bus-number',
            self::GROUP_VIDEO_ANALYST => 'video-analyst',
            self::GROUP_POLICE_OFFICER => 'police-officer',
            self::GROUP_PRINT_OPERATOR => 'print-operator',
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
}
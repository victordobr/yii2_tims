<?php
namespace app\enums\report;

use Yii;

/**
 * CaseStage Enum
 * @package app\enums
 */
class ReportType extends \kfosoft\base\Enum
{
    const SUMMARY_DETAIL_REPORTS = 1;
    const OPERATIONAL_REPORTS = 2;
    const FINANCIAL_REPORTS = 3;

    const SUMMARY_REPORTS = 4;
    const DETAIL_REPORTS = 5;
    const INVESTIGATIVE_REPORTS = 6;
    const ADMINISTRATIVE_REPORTS = 7;
    const EXCEPTION_REPORTS = 8;
    const SETTLEMENT_REPORTS = 9;

    const SUMMARY_REPORT_DASHBOARD_VIEW = 10;
    const SUMMARY_REPORT_VIOLATIONS_BY_DATE = 11;
    const SUMMARY_REPORT_VIOLATIONS_BY_SCHOOL_BUS = 12;
    const SUMMARY_REPORT_VIOLATIONS_BY_VIDEO_ANALYST = 13;
    const SUMMARY_REPORT_VIOLATIONS_BY_POLICE_OFFICER = 14;
    const SUMMARY_REPORT_VIOLATIONS_BY_PRINT_OPERATOR = 15;

    const DETAIL_REPORT_BUS_NUMBER = 16;
    const DETAIL_REPORT_VIDEO_ANALYST = 17;
    const DETAIL_REPORT_POLICE_OFFICER = 18;
    const DETAIL_REPORT_PRINT_OPERATOR = 19;

    const DETAIL_REPORT_VIOLATION_COUNT_X = 20;
    const DETAIL_REPORT_VEHICLE_TAG_NUMBER = 21;
    const DETAIL_REPORT_NAME_DOB = 22;

    const PERFORMANCE_SUMMARY = 23;
    const PERFORMANCE_DETAIL = 24;
    const AUDIT_LOG = 25;

    /**
     * List of color names.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::SUMMARY_DETAIL_REPORTS => Yii::t('app', 'Summary/Detail'),
            self::OPERATIONAL_REPORTS => Yii::t('app', 'Operational'),
            self::FINANCIAL_REPORTS => Yii::t('app', 'Financial'),

            self::SUMMARY_REPORTS => Yii::t('app', 'SUMMARY REPORTS'),
            self::DETAIL_REPORTS => Yii::t('app', 'DETAIL REPORTS'),
            self::INVESTIGATIVE_REPORTS => Yii::t('app', 'INVESTIGATIVE REPORTS'),
            self::ADMINISTRATIVE_REPORTS => Yii::t('app', 'ADMINISTRATIVE REPORTS'),
            self::EXCEPTION_REPORTS => Yii::t('app', 'EXCEPTION REPORTS'),
            self::SETTLEMENT_REPORTS => Yii::t('app', 'SETTLEMENT REPORTS'),

            self::SUMMARY_REPORT_DASHBOARD_VIEW => Yii::t('app', 'Summary Report – Dashboard View'),
            self::SUMMARY_REPORT_VIOLATIONS_BY_DATE => Yii::t('app', 'Summary Report – Violations by Date'),
            self::SUMMARY_REPORT_VIOLATIONS_BY_SCHOOL_BUS => Yii::t('app', 'Summary Report – Violations by School Bus'),
            self::SUMMARY_REPORT_VIOLATIONS_BY_VIDEO_ANALYST => Yii::t('app', 'Summary Report – Violations by Video Analyst'),
            self::SUMMARY_REPORT_VIOLATIONS_BY_POLICE_OFFICER => Yii::t('app', 'Summary Report – Violations by Police Officer'),
            self::SUMMARY_REPORT_VIOLATIONS_BY_PRINT_OPERATOR => Yii::t('app', 'Summary Report – Violations by Print Operator'),

            self::DETAIL_REPORT_BUS_NUMBER => Yii::t('app', 'Detail Report – Bus Number'),
            self::DETAIL_REPORT_VIDEO_ANALYST => Yii::t('app', 'Detail Report – Video Analyst'),
            self::DETAIL_REPORT_POLICE_OFFICER => Yii::t('app', 'Detail Report – Police Officer'),
            self::DETAIL_REPORT_PRINT_OPERATOR => Yii::t('app', 'Detail Report – Print Operator'),

            self::DETAIL_REPORT_VIOLATION_COUNT_X => Yii::t('app', 'Detail Report – Violation Count X'),
            self::DETAIL_REPORT_VEHICLE_TAG_NUMBER => Yii::t('app', 'Detail Report – Vehicle TAG#'),
            self::DETAIL_REPORT_NAME_DOB => Yii::t('app', 'Detail Report – Name/DOB'),

            self::PERFORMANCE_SUMMARY => Yii::t('app', 'Performance Summary'),
            self::PERFORMANCE_DETAIL => Yii::t('app', 'Performance Detail'),
            self::AUDIT_LOG => Yii::t('app', 'Audit Log'),
        ];
    }

    public static function listUrl()
    {
        return [
            self::SUMMARY_REPORT_DASHBOARD_VIEW => false,//'summary-report–dashboard-view',
            self::SUMMARY_REPORT_VIOLATIONS_BY_DATE => 'summary-report/violations-by-date',
            self::SUMMARY_REPORT_VIOLATIONS_BY_SCHOOL_BUS => 'summary-report/violations-by-school-bus',
            self::SUMMARY_REPORT_VIOLATIONS_BY_VIDEO_ANALYST => 'summary-report/violations-by-video-analyst',
            self::SUMMARY_REPORT_VIOLATIONS_BY_POLICE_OFFICER => 'summary-report/violations-by-police-officer',
            self::SUMMARY_REPORT_VIOLATIONS_BY_PRINT_OPERATOR => 'summary-report/violations-by-print-operator',

            self::DETAIL_REPORT_BUS_NUMBER => 'detail-report/bus-number',
            self::DETAIL_REPORT_VIDEO_ANALYST => 'detail-report/video-analyst',
            self::DETAIL_REPORT_POLICE_OFFICER => 'detail-report/police-officer',
            self::DETAIL_REPORT_PRINT_OPERATOR => 'detail-report/print-operator',

            self::DETAIL_REPORT_VIOLATION_COUNT_X => false,
            self::DETAIL_REPORT_VEHICLE_TAG_NUMBER => false,
            self::DETAIL_REPORT_NAME_DOB => false,

            self::PERFORMANCE_SUMMARY => false,
            self::PERFORMANCE_DETAIL => false,
            self::AUDIT_LOG => false,
        ];
    }

    /**
     * Hierarchy of Report Types
     * @return array
     */
    public static function getHierarchy()
    {
        return [
            self::SUMMARY_DETAIL_REPORTS => [
                self::SUMMARY_REPORTS => [
                    self::SUMMARY_REPORT_DASHBOARD_VIEW,
                    self::SUMMARY_REPORT_VIOLATIONS_BY_DATE,
                    self::SUMMARY_REPORT_VIOLATIONS_BY_SCHOOL_BUS,
                    self::SUMMARY_REPORT_VIOLATIONS_BY_VIDEO_ANALYST,
                    self::SUMMARY_REPORT_VIOLATIONS_BY_POLICE_OFFICER,
                    self::SUMMARY_REPORT_VIOLATIONS_BY_PRINT_OPERATOR,
                ],
                self::DETAIL_REPORTS => [
                    self::DETAIL_REPORT_BUS_NUMBER,
                    self::DETAIL_REPORT_VIDEO_ANALYST,
                    self::DETAIL_REPORT_POLICE_OFFICER,
                    self::DETAIL_REPORT_PRINT_OPERATOR,
                ],
                self::INVESTIGATIVE_REPORTS => [
                    self::DETAIL_REPORT_VIOLATION_COUNT_X,
                    self::DETAIL_REPORT_VEHICLE_TAG_NUMBER,
                    self::DETAIL_REPORT_NAME_DOB,
                ],
                self::ADMINISTRATIVE_REPORTS => [
                    self::PERFORMANCE_SUMMARY,
                    self::PERFORMANCE_DETAIL,
                    self::AUDIT_LOG,
                ],

            ],
            self::OPERATIONAL_REPORTS => [
                self::SUMMARY_REPORTS => [
//                    self::DASHBOARD_VIEW,
                ],
            ],
            self::FINANCIAL_REPORTS => [
                self::SUMMARY_REPORTS => [
//                    self::DASHBOARD_VIEW,
                ],
            ],
        ];
    }
}
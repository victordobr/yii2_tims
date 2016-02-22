<?php
namespace app\enums\report;

use Yii;
use yii\helpers\Html;

/**
 * CaseStage Enum
 * @package app\enums
 */
class ReportType extends \kfosoft\base\Enum
{
    const SUMMARY_REPORTS = 1;
    const OPERATIONAL_REPORTS = 2;
    const FINANCIAL_REPORTS = 3;

    const OVERALL_SUMMARY_DASHBOARD = 4;
    const OVERALL_OPERATIONS_DASHBOARD = 5;
    const OVERALL_FINANCIAL_DASHBOARD = 6;
    const VIOLATIONS_BY_DATE = 7;
    const ALL_VIOLATION_DETAILS = 8;
    const ALL_CITATIONS_PENDING_PAYMENT = 9;
    const VIOLATIONS_BY_SCHOOL_BUS = 10;
    const VIOLATIONS_PENDING_DMV_DATA = 11;
    const ALL_CITATIONS_PAID = 12;

    /**
     * List of color names.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::SUMMARY_REPORTS  => Yii::t('app', 'SUMMARY REPORTS'),
            self::OPERATIONAL_REPORTS  => Yii::t('app', 'OPERATIONAL REPORTS'),
            self::FINANCIAL_REPORTS  => Yii::t('app', 'FINANCIAL REPORTS'),
            self::OVERALL_SUMMARY_DASHBOARD  => Yii::t('app', 'Overall Summary Dashboard'),
            self::OVERALL_OPERATIONS_DASHBOARD  => Yii::t('app', 'Overall Operations Dashboard'),
            self::OVERALL_FINANCIAL_DASHBOARD  => Yii::t('app', 'Overall Financial Dashboard'),
            self::VIOLATIONS_BY_DATE  => Yii::t('app', 'Violations by Date'),
            self::ALL_VIOLATION_DETAILS  => Yii::t('app', 'All Violation Details'),
            self::ALL_CITATIONS_PENDING_PAYMENT  => Yii::t('app', 'All Citations Pending Payment'),
            self::VIOLATIONS_BY_SCHOOL_BUS  => Yii::t('app', 'Violations by School Bus'),
            self::VIOLATIONS_PENDING_DMV_DATA  => Yii::t('app', 'Violations Pending DMV Data'),
            self::ALL_CITATIONS_PAID  => Yii::t('app', 'All Citations Paid'),
        ];
    }

    public static function listUrl()
    {
        return [
            self::OVERALL_SUMMARY_DASHBOARD  => 'test',
            self::OVERALL_OPERATIONS_DASHBOARD  => 'test',
            self::OVERALL_FINANCIAL_DASHBOARD  => 'test',
            self::VIOLATIONS_BY_DATE  => 'violations-by-date',
            self::ALL_VIOLATION_DETAILS  => 'test',
            self::ALL_CITATIONS_PENDING_PAYMENT  => 'test',
            self::VIOLATIONS_BY_SCHOOL_BUS  => 'test',
            self::VIOLATIONS_PENDING_DMV_DATA  => 'test',
            self::ALL_CITATIONS_PAID  => 'test',
        ];
    }


    /**
     * Hierarchy of Report Types
     * @return array
     */
    public static function getHierarchy()
    {
        return [
            self::SUMMARY_REPORTS => [
                self::OVERALL_SUMMARY_DASHBOARD,
                self::VIOLATIONS_BY_DATE,
                self::VIOLATIONS_BY_SCHOOL_BUS,
            ],
            self::OPERATIONAL_REPORTS => [
                self::OVERALL_OPERATIONS_DASHBOARD,
                self::ALL_VIOLATION_DETAILS,
                self::VIOLATIONS_PENDING_DMV_DATA,
            ],
            self::FINANCIAL_REPORTS => [
                self::OVERALL_FINANCIAL_DASHBOARD,
                self::ALL_CITATIONS_PENDING_PAYMENT,
                self::ALL_CITATIONS_PAID,
            ],
        ];
    }

    public static function createItems()
    {
        $list = [];
        $list_url = self::listUrl();
        foreach (self::getHierarchy() as $parent_id => $ids) {
            $list = [];
            foreach ($ids as $id) {
                $list[$id]['id'] = $id;
                $list[$id]['url'] = Html::a(parent::labelById($id), [$list_url[$id]], ['class' => '']);
            }
            $list_arr[$parent_id] = $list;
        }
        return $list_arr;
    }

//    /**
//     * Hierarchy of Report Types
//     * @return array
//     */
//    public static function getMainTypes()
//    {
//        return [
//            self::SUMMARY_REPORTS  => Yii::t('app', 'SUMMARY REPORTS'),
//            self::OPERATIONAL_REPORTS  => Yii::t('app', 'OPERATIONAL REPORTS'),
//            self::FINANCIAL_REPORTS  => Yii::t('app', 'FINANCIAL REPORTS'),
//        ];
//    }
}
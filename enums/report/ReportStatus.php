<?php
namespace app\enums\report;

use \Yii;
use \kfosoft\base\Enum;

/**
 * ReportStatus Enum
 * @package app\enums
 */
class ReportStatus extends Enum
{
    const COMPLETE = 1020;
    const DEACTIVATED_RECORD = 1040;
    const VIEWED_RECORD = 2010;
    const APPROVED_RECORD = 2020;
    const REJECTED_RECORD = 2030;
    const DMV_DATA_RETRIEVED_COMPLETE = 3020;
    const DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL = 3030;
    const PRINTED_P1 = 4010;
    const PRINTED_P2 = 4040;
    const PAID = 5030;
    const COURT_DATE_REQUESTED = 5040;
    const GROUP_UPLOADS = 1;
    const GROUP_REVIEWS = 2;
    const GROUP_PRINT_MAIL = 3;
    const GROUP_PAYMENT = 4;

    /**
     * The list of groups with the statuses
     * @return array
     */
    public static function listGroupsReport()
    {
        return [
            self::GROUP_UPLOADS => Yii::t('app', 'Uploads'),
            self::GROUP_REVIEWS => Yii::t('app', 'Reviews'),
            self::GROUP_PRINT_MAIL => Yii::t('app', 'Print & Mail'),
            self::GROUP_PAYMENT => Yii::t('app', 'Payment'),
        ];
    }

    /**
     * @return array
     */
    public static function listStatusesReport()
    {
        return [
            self::COMPLETE => Yii::t('app', 'Cases Uploaded'), //1020
            self::DEACTIVATED_RECORD => Yii::t('app', 'Cases Deactivated'), //1040

            self::VIEWED_RECORD => Yii::t('app', 'Cases Reviewed'), //2010
            self::APPROVED_RECORD => Yii::t('app', 'Violation Approved'), //2020
            self::REJECTED_RECORD => Yii::t('app', 'Violation NOT Approved'), //2030

            self::DMV_DATA_RETRIEVED_COMPLETE => Yii::t('app', 'Retrieved DMV Data'), //3020
            self::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL => Yii::t('app', 'No DMV Data Match Found'), //3030
            self::PRINTED_P1 => Yii::t('app', 'Citations Printed & Mailed - Period 1'), //4010
            self::PRINTED_P2 => Yii::t('app', 'Citations Printed & Mailed - Period 2'), //4040

            self::PAID => Yii::t('app', 'Citations Paid (Online)'), //5030
            self::COURT_DATE_REQUESTED => Yii::t('app', 'Court Date Requested'), //5040
        ];
    }

    /**
     * Group of Statuses
     * @return array
     */
    public static function structureStatusesReport()
    {
        return [
            self::GROUP_UPLOADS => [ // 1
                self::COMPLETE, //1020
                self::DEACTIVATED_RECORD, //1040
            ],
            self::GROUP_REVIEWS => [ // 2
                self::VIEWED_RECORD, //2010
                self::APPROVED_RECORD, //2020
                self::REJECTED_RECORD, //2030
            ],
            self::GROUP_PRINT_MAIL => [ // 3
                self::DMV_DATA_RETRIEVED_COMPLETE, //3020
                self::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL, //3030
                self::PRINTED_P1, //4010
                self::PRINTED_P2, //4040
            ],
            self::GROUP_PAYMENT => [ // 4
                self::PAID, //5030
                self::COURT_DATE_REQUESTED, //5030
            ],
        ];
    }

}
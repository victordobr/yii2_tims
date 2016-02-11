<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * CaseStatus Enum
 * @package app\enums
 */
class CaseStatus extends Enum
{
    const INCOMPLETE = 1010;
    const COMPLETE = 1020;
    const FULL_COMPLETE = 1021;
    const AWAITING_DEACTIVATION = 1030;
    const DEACTIVATED_RECORD = 1040;
    const HOLD_1999 = 1999;

    const VIEWED_RECORD = 2010;
    const APPROVED_RECORD_2020 = 2020;
    const APPROVED_RECORD_2021 = 2021;
    const REJECTED_RECORD_2030 = 2030;
    const REJECTED_RECORD_2031 = 2031;
    const AWAITING_CHANGE = 2040;
    const HOLD_2999 = 2999;

    const QUERY_SUBMITTED = 3010;
    const DMV_DATA_RETRIEVED_COMPLETE = 3020;
    const DMV_DATA_RETRIEVED_INCOMPLETE = 3021;
    const DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL = 3030;
    const DMV_DATA_CORRUPT = 3031;
    const DMV_DATA_NOT_AVAILABLE = 3032;
    const DMV_DATA_MULTIPLE_MATCH = 3033;
    const HOLD_3999 = 3999;

    const PRINTED_P1 = 4010;
    const QC_CONFIRMED_GOOD_P1 = 4020;
    const QC_BAD_P1 = 4030;
    const PRINTED_P2 = 4040;
    const QC_CONFIRMED_GOOD_P2 = 4050;
    const QC_BAD_P2 = 4060;

    const RECEIVED_P1 = 5010;
    const VIEWED_RECORD_P1 = 5011;
    const RECEIVED_P2 = 5020;
    const VIEWED_RECORD_P2 = 5021;
    const PAID = 5030;
    const COURT_DATE_REQUESTED = 5040;
    const COURT_DATE_SET = 5041;
    const COURT_VERDICT_RETURNED = 5042;
    const DISPUTED_AFFIDAVIT = 5050;
    const OVERDUE_P1 = 5060;
    const OVERDUE_P2 = 5061;
    const SENT_TO_COLLECTIONS = 5070;
    const HOLD_5999 = 5999;
    
    const CLOSED_PAID = 6010;
    const CLOSED_UNPAID = 6011;
    const ARCHIVED = 6020;
    const RECORD_HOLD = 6021;
    const MARKED_FOR_PURGE_30D = 6022;

    public static function listMainText()
    {
        return [
            self::INCOMPLETE  => Yii::t('app', 'Incomplete – Pending Upload Finalisation'), //1010
            self::COMPLETE  => Yii::t('app', 'Waiting for Evidence Review'), //1020
            self::FULL_COMPLETE  => Yii::t('app', 'Waiting for Evidence Review'), //1021
            self::VIEWED_RECORD  => Yii::t('app', 'Waiting for Evidence Review'), //2010
            self::AWAITING_DEACTIVATION  => Yii::t('app', 'Waiting for Deactivation'), //1030
            self::DEACTIVATED_RECORD  => Yii::t('app', 'Deactivated Case'), //1040
            self::APPROVED_RECORD_2020  => Yii::t('app', 'Waiting for DMV Data'), //2020
            self::APPROVED_RECORD_2021  => Yii::t('app', 'Waiting for DMV Data'), //2021
            self::QUERY_SUBMITTED  => Yii::t('app', 'Waiting for DMV Data'), //3010
            self::REJECTED_RECORD_2030  => Yii::t('app', 'Rejected Case'), //2030
            self::REJECTED_RECORD_2031  => Yii::t('app', 'Rejected Case'), //2031
            self::DMV_DATA_RETRIEVED_COMPLETE  => Yii::t('app', 'Waiting for Citation Print/Mail'), //3020
            self::DMV_DATA_RETRIEVED_INCOMPLETE  => Yii::t('app', 'Waiting for Citation Print/Mail'), //3021
            self::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL  => Yii::t('app', 'NLETS ERR'), //3030
            self::DMV_DATA_CORRUPT  => Yii::t('app', 'NLETS ERR'), //3031
            self::DMV_DATA_NOT_AVAILABLE  => Yii::t('app', 'NLETS ERR'), //3032
            self::DMV_DATA_MULTIPLE_MATCH  => Yii::t('app', 'NLETS ERR'), //3033
            self::PRINTED_P1  => Yii::t('app', 'Citation Printed/Mailed (Period X)'), //4010
            self::PRINTED_P2  => Yii::t('app', 'Citation Printed/Mailed (Period X)'), //4040
            self::VIEWED_RECORD_P1  => Yii::t('app', 'Violator Received, Waiting for Payment'), //5011
            self::VIEWED_RECORD_P2  => Yii::t('app', 'Violator Received, Waiting for Payment'), //5021
            self::PRINTED_P1  => Yii::t('app', 'Payment Overdue'), //4010/5011
            self::PAID  => Yii::t('app', 'Paid'), //5030
        ];
    }

    public static function listSubText($dictionary = [])
    {
        return [
            self::INCOMPLETE  => Yii::t('app', '(upload deadline in {N} days)', $dictionary), //1010
            self::COMPLETE  => Yii::t('app', '(review deadline in {N} days)', $dictionary), //1020
            self::FULL_COMPLETE  => Yii::t('app', '(review deadline in {N} days)', $dictionary), //1021
            self::VIEWED_RECORD  => Yii::t('app', '(review deadline in {N} days)', $dictionary), //2010
            self::AWAITING_DEACTIVATION  => Yii::t('app', '(requested by {requester_username}, {datetime})', $dictionary), //1030
            self::DEACTIVATED_RECORD  => Yii::t('app', '(deactivated by {requester_username}, {datetime})', $dictionary), //1040
            self::APPROVED_RECORD_2020  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //2020
            self::APPROVED_RECORD_2021  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //2021
            self::QUERY_SUBMITTED  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //3010
            self::REJECTED_RECORD_2030  => Yii::t('app', '(rejected by {approvers_username}, {datetime})', $dictionary), //2030
            self::REJECTED_RECORD_2031  => Yii::t('app', '(rejected by {approvers_username}, {datetime})', $dictionary), //2031
            self::DMV_DATA_RETRIEVED_COMPLETE  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //3020
            self::DMV_DATA_RETRIEVED_INCOMPLETE  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //3021
            self::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //3030
            self::DMV_DATA_CORRUPT  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //3031
            self::DMV_DATA_NOT_AVAILABLE  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //3032
            self::DMV_DATA_MULTIPLE_MATCH  => Yii::t('app', '(print deadline in {N} days)', $dictionary), //3033
            self::PRINTED_P1  => Yii::t('app', '(printed by {operator_username}, {datetime})', $dictionary), //4010
            self::PRINTED_P2  => Yii::t('app', '(printed by {operator_username}, {datetime})', $dictionary), //4040
            self::VIEWED_RECORD_P1  => Yii::t('app', '(due in {N} days)', $dictionary), //5011
            self::VIEWED_RECORD_P2  => Yii::t('app', '(due in {N} days)', $dictionary), //5021
            self::PRINTED_P1  => Yii::t('app', '(print P2 citation for mailing)', $dictionary), //4010/5011
            self::PAID  => Yii::t('app', '(payment received {datetime})', $dictionary), //5030
        ];
    }
}
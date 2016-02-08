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

    const DMV_DATA_RETRIEVED_COMPLETE = 3020;
    const DMV_DATA_RETRIEVED_INCOMPLETE = 3021;

    const PRINTED_P1 = 4010;
    const QC_CONFIRMED_GOOD_P1 = 4020;
    const QC_BAD_P1 = 4030;
    const PRINTED_P2 = 4040;
    const QC_CONFIRMED_GOOD_P2 = 4050;
    const QC_BAD_P2 = 4060;

    const OVERDUE_P1 = 5060;
}
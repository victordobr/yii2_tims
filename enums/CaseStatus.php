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

}
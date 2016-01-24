<?php
namespace app\enums;

use \Yii;
use app\models\User;
use \kfosoft\base\Enum;

/**
 * UserType Enum
 * @package app\enums
 */
class CaseStatus extends Enum
{
    const INCOMPLETE = 1010;
    const COMPLETE = 1020;
    const FULL_COMPLETE = 1021;

}
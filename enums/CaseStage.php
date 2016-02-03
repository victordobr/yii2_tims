<?php
namespace app\enums;

/**
 * CaseStage Enum
 * @package app\enums
 */
class CaseStage extends \kfosoft\base\Enum
{
    const SET_INFRACTION_DATE = 1;
    const DATA_UPLOADED = 2;
    const VIOLATION_APPROVED = 3;
    const DMV_DATA_REQUEST = 4;
    const CITATION_PRINTED = 5;
    const CITATION_QC_VERIFIED = 6;
}
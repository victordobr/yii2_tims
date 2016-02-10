<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;
/**
 * Reasons Enum
 * @package app\enums
 *
 * @author Alex Makhorin
 */
class Reasons extends Enum
{
    const MISSING_WRONG_VIDEO_OR_IMAGE = '10';
    const NON_COMPLIANT_VIDEO_OR_IMAGE = '11';
    const INFRACTION_DATE_WRONG = '12';
    const BUS_NUMBER_WRONG = '13';
    const GPS_DATA_WRONG = '14';
    const TAG_DATA_WRONG = '15';

    const NOT_DATA_ENTRY_ERROR = '20';
    const NOT_OPERATIONAL_ERROR = '21';
    const CASE_MEETS_SUBMISSION_REQUIREMENTS = '22';
    
    const NOT_A_VIOLATION = '30';
    const NON_COMPLIANT_VIDEO_OR_IMAGE_31 = '31';
    const MISSING_WRONG_VIDEO_OR_IMAGE_32 = '32';
    const MISSING_WRONG_DATA = '33';
    const INSUFFICIENT_BASIS_FOR_CITATION = '34';

    const OTHER = '99';

    /**
     * List data.
     * @return array|null data.
     */
    public static function listReasonsRequestDeactivation()
    {
        return [
            self::MISSING_WRONG_VIDEO_OR_IMAGE  => Yii::t('app', 'Missing/wrong video or image'),
            self::NON_COMPLIANT_VIDEO_OR_IMAGE  => Yii::t('app', 'Non-compliant video or image'),
            self::INFRACTION_DATE_WRONG  => Yii::t('app', 'Infraction date wrong'),
            self::BUS_NUMBER_WRONG  => Yii::t('app', 'Bus number wrong'),
            self::GPS_DATA_WRONG  => Yii::t('app', 'GPS data wrong'),
            self::TAG_DATA_WRONG  => Yii::t('app', 'TAG data wrong'),
            self::OTHER => Yii::t('app', 'Other – manually key in the reason description'),
        ];
    }

    /**
     * List data.
     * @return array|null data.
     */
    public static function listReasonsRejectingDeactivationRequest()
    {
        return [
            self::NOT_DATA_ENTRY_ERROR  => Yii::t('app', 'Not data entry error'),
            self::NOT_OPERATIONAL_ERROR  => Yii::t('app', 'Not operational error'),
            self::CASE_MEETS_SUBMISSION_REQUIREMENTS  => Yii::t('app', 'Case meets submission requirements'),
            self::OTHER => Yii::t('app', 'Other – manually key in the reason description'),
        ];
    }

    /**
     * List data.
     * @return array|null data.
     */
    public static function listReasonsRejectingCase()
    {
        return [
            self::NOT_A_VIOLATION  => Yii::t('app', 'Not a violation'),
            self::NON_COMPLIANT_VIDEO_OR_IMAGE_31  => Yii::t('app', 'Non-compliant video or image'),
            self::MISSING_WRONG_VIDEO_OR_IMAGE_32  => Yii::t('app', 'Missing/wrong video or image'),
            self::MISSING_WRONG_DATA  => Yii::t('app', 'Missing/wrong data'),
            self::INSUFFICIENT_BASIS_FOR_CITATION  => Yii::t('app', 'Insufficient basis for citation'),
            self::OTHER => Yii::t('app', 'Other – manually key in the reason description'),
        ];
    }
}

<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * UserType Enum
 * @package app\enums
 */
class EvidenceFileType extends Enum
{
    const TYPE_VIDEO_LPR = '1';
    const TYPE_VIDEO_OVERVIEW_CAMERA = '2';
    const TYPE_IMAGE_LPR = '3';
    const TYPE_IMAGE_OVERVIEW_CAMERA = '4';

    /**
     * List data.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::TYPE_VIDEO_LPR  => Yii::t('app', 'Video from *LPR'),
            self::TYPE_VIDEO_OVERVIEW_CAMERA => Yii::t('app', 'Video from Overview Camera'),
            self::TYPE_IMAGE_LPR => Yii::t('app', 'Still Image from *LPR'),
            self::TYPE_IMAGE_OVERVIEW_CAMERA => Yii::t('app', 'Still Image from Overview Camera'),
        ];
    }
}

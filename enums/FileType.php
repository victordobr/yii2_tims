<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * UserType Enum
 * @package app\enums
 */
class FileType extends Enum
{
    const TYPE_VIDEO = '1';
    const TYPE_IMAGE = '2';

    /**
     * List data.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::TYPE_VIDEO  => Yii::t('app', 'Video'),
            self::TYPE_IMAGE => Yii::t('app', 'Image'),
        ];
    }
}

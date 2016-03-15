<?php
namespace app\enums;

use \Yii;
use \kfosoft\base\Enum;

/**
 * VarType Enum
 * @package app\enums
 */
class VarType extends Enum
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_FLOAT = 'float';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';
    const TYPE_NULL = 'null';

    /**
     * List data.
     * @return array|null data.
     */
    public static function listData()
    {
        return [
            self::TYPE_STRING  => Yii::t('app', 'String'),
            self::TYPE_INTEGER => Yii::t('app', 'Integer'),
            self::TYPE_BOOLEAN => Yii::t('app', 'Boolean'),
            self::TYPE_FLOAT => Yii::t('app', 'Float'),
            self::TYPE_ARRAY => Yii::t('app', 'Array'),
            self::TYPE_OBJECT => Yii::t('app', 'Object'),
            self::TYPE_NULL => Yii::t('app', 'Null'),
        ];
    }
}
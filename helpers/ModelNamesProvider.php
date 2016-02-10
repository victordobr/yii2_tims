<?php
namespace app\helpers;

/**
 * Model names provider
 * @package app\helpers
 */
class ModelNamesProvider
{
    const ADMIN_USER_SEARCH = 4;

    /**
     * @return array Array of model names
     */
    private static function getModelNames()
    {
        return [
            self::ADMIN_USER_SEARCH => \app\modules\admin\models\search\User::className(),
        ];
    }

    /**
     * @param int $code Code of model
     * @return string|null Name of model class
     */
    public static function getModelNameByCode($code)
    {
        return isset(self::getModelNames()[$code]) ? self::getModelNames()[$code] : null;
    }
}
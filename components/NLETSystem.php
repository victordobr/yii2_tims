<?php

namespace app\components;

use Yii;

/**
 * Class NLETSystem
 *
 * Simulation work of National Law Enforcement Telecommunications System
 *
 * @package app\components
 * @author Eugene Gichko <eugene.gichko@gmail.com>
 */
class NLETSystem
{
    private static $data = null;

    /**
     * Retrieve Department of Motor Vehicles data
     *
     * @param string $tag
     *
     * @return array|null
     */
    public static function retrieveDMVData($tag)
    {
        $data = self::initData();

        return array_key_exists($tag, $data) ? $data[$tag] : null;
    }

    /**
     * @return bool|array
     */
    private static function initData()
    {
        if (is_null(self::$data)) {
            $file = Yii::getAlias('@app/config/plates.php');
            self::$data = file_exists($file) ? require($file) : false;
        }

        return self::$data;
    }

}
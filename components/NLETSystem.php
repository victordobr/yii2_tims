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

        return array_key_exists($tag, $data) ? self::parseData($data[$tag]) : null;
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

    /**
     * @param array $data
     *
     * @return array
     */
    private static function parseData(array $data)
    {
        $name = explode(' ', $data['OwnerName']);
        $owner = [
            'first_name' => !empty($name[0]) ? $name[0] : '',
            'last_name' => !empty($name[1]) ? $name[1] : '',
            'address_1' => $data['OwnerAddress1'],
            'address_2' => $data['OwnerAddress2'],
            'city' => $data['OwnerCity'],
            'state_id' => 9, // todo: temp
            'zip_code' => $data['OwnerZIP'],
        ];
        $vehicle = [
            'tag' => $data['Plate'],
            'state' => 9, // todo: temp
            'year' => (string)$data['VehYear'],
            'make' => $data['VehMake'],
            'model' => $data['VehModel'],
            'color' => 'white', // todo: temp
        ];

        return [
            'owner' => $owner,
            'vehicle' => $vehicle,
        ];
    }

}
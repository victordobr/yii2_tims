<?php

namespace app\components;

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
    private static $data = [
        'DR460N' => [
            'vehicle' => [
                'plate' => 'DR460N',
                'state' => 'GA',
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => '2010',
                'color' => 'white',
            ],
            'owner' => [
                'first_name' => 'Theodore',
                'middle_name' => '',
                'last_name' => 'Montgomery',
                'address' => '3240 164th St. Suite 520',
                'city' => 'Hampshire place',
                'state' => 'GA',
                'postal_code' => 31032,
            ],
        ],
        'GR390L' => [
            'vehicle' => [
                'plate' => 'GR390L',
                'state' => 'GA',
                'make' => 'Audi',
                'model' => 'A3 3',
                'year' => '2012',
                'color' => 'orange',
            ],
            'owner' => [
                'first_name' => 'John',
                'middle_name' => '',
                'last_name' => 'Montgomery',
                'address' => '3240 164th St. Suite 520',
                'city' => 'Hampshire place',
                'state' => 'GA',
                'postal_code' => 31032,
            ],
        ],
    ];

    /**
     * Retrieve Department of Motor Vehicles data
     *
     * @param string $tag
     *
     * @return array|null
     */
    public static function retrieveDMVData($tag)
    {
        return array_key_exists($tag, self::$data) ? self::$data[$tag] : null;
    }

}
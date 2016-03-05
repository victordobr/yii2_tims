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
        'DR4 60N' => [
            'vehicle' => [
                'plate' => 'DR4 60N',
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
        ]
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
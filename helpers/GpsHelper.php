<?php

namespace app\helpers;

/**
 * Class TimsHelper
 *
 * Base helper file of the project
 * @package app\helpers
 */
class GpsHelper
{

    /**
     * Convert DMS (degrees / minutes / seconds) to decimal degrees
     *
     * @param string $latlng Latitude or longitude. For example $latlng = '49º 59' 36.6" N'
     * @return integer $decimal_degrees
     */
    public static function convertDMSToDecimal($latlng) {

        $valid = false;
        $decimal_degrees = 0;
        $degrees = 0; $minutes = 0; $seconds = 0; $direction = 1;
        // Determine if there are extra periods in the input string
        $num_periods = substr_count($latlng, '.');
        if ($num_periods > 1) {
            $temp = preg_replace('/\./', ' ', $latlng, $num_periods - 1); // replace all but last period with delimiter
            $temp = trim(preg_replace('/[a-zA-Z]/','',$temp)); // when counting chunks we only want numbers
            $chunk_count = count(explode(" ",$temp));
            if ($chunk_count > 2) {
                $latlng = preg_replace('/\./', ' ', $latlng, $num_periods - 1); // remove last period
            } else {
                $latlng = str_replace("."," ",$latlng); // remove all periods, not enough chunks left by keeping last one
            }
        }

        // Remove unneeded characters
        $latlng = trim($latlng);
        $latlng = str_replace("º","",$latlng);
        $latlng = str_replace("'","",$latlng);
        $latlng = str_replace("\"","",$latlng);
        $latlng = substr($latlng,0,1) . str_replace('-', ' ', substr($latlng,1)); // remove all but first dash

        if ($latlng != "") {
            // DMS with the direction at the start of the string
            if (preg_match("/^([nsewNSEW]?)\s*(\d{1,3})\s+(\d{1,3})\s+(\d+\.?\d*)$/",$latlng,$matches)) {
                $valid = true;
                $degrees = intval($matches[2]);
                $minutes = intval($matches[3]);
                $seconds = floatval($matches[4]);
                if (strtoupper($matches[1]) == "S" || strtoupper($matches[1]) == "W")
                    $direction = -1;
            }
            // DMS with the direction at the end of the string
            elseif (preg_match("/^(-?\d{1,3})\s+(\d{1,3})\s+(\d+(?:\.\d+)?)\s*([nsewNSEW]?)$/",$latlng,$matches)) {
                $valid = true;
                $degrees = intval($matches[1]);
                $minutes = intval($matches[2]);
                $seconds = floatval($matches[3]);
                if (strtoupper($matches[4]) == "S" || strtoupper($matches[4]) == "W" || $degrees < 0) {
                    $direction = -1;
                    $degrees = abs($degrees);
                }
            }
            if ($valid) {
                // A match was found, do the calculation
                $decimal_degrees = ($degrees + ($minutes / 60) + ($seconds / 3600)) * $direction;
            } else {
                // Decimal degrees with a direction at the start of the string
                if (preg_match("/^([nsewNSEW]?)\s*(\d+(?:\.\d+)?)$/",$latlng,$matches)) {
                    $valid = true;
                    if (strtoupper($matches[1]) == "S" || strtoupper($matches[1]) == "W")
                        $direction = -1;
                    $decimal_degrees = $matches[2] * $direction;
                }
                // Decimal degrees with a direction at the end of the string
                elseif (preg_match("/^(-?\d+(?:\.\d+)?)\s*([nsewNSEW]?)$/",$latlng,$matches)) {
                    $valid = true;
                    if (strtoupper($matches[2]) == "S" || strtoupper($matches[2]) == "W" || $degrees < 0) {
                        $direction = -1;
                        $degrees = abs($degrees);
                    }
                    $decimal_degrees = $matches[1] * $direction;
                }
            }
        }
        if ($valid) {
            return $decimal_degrees;
        } else {
            return false;
        }
    }

    /**
     * Convert DDM (degrees / decimal minutes) to decimal degrees
     *
     * @param string $latlng Latitude or longitude. For example $latlng = '49.59.366N'
     * @return integer $decimal_degrees
     */
    public static function convertDDMToDecimal($latlng) {

        $decimal_degrees = 0;
        $degrees = 0; $minutes = 0; $seconds = 0; $direction = 1;

        if (preg_match("/^(\d{1,3}).(\d{1,3}.\d{1,9})*([nsewNSEW])$/", $latlng, $matches)) {
            $degrees = intval($matches[1]);
            $dec_minutes = floatval($matches[2]);
            if (strtoupper($matches[3]) == "S" || strtoupper($matches[3]) == "W")
                $direction = -1;

            $minutes = floor($dec_minutes);
            $seconds = 60 * ($dec_minutes - $minutes);
            $decimal_degrees = ($degrees + ($minutes / 60) + ($seconds / 3600)) * $direction;

           return $decimal_degrees;
        }
        else {
            return false;
        }
    }

    /**
     * Convert DDM (degrees / decimal minutes) to DMS (degrees / minutes / seconds)
     *
     * @param string $latlng Latitude or longitude. For example $latlng = '49.59.366N'
     * @return string $dms
     */
    public static function convertDDMToDMS($latlng) {

        $decimal_degrees = 0;
        $degrees = 0; $minutes = 0; $seconds = 0; $direction = 1;

        if (preg_match("/^(\d{1,3}).(\d{1,3}.\d{1,9})*([nsewNSEW])$/", $latlng, $matches)) {
            $degrees = intval($matches[1]);
            $dec_minutes = floatval($matches[2]);
            if (strtoupper($matches[3]) == "S" || strtoupper($matches[3]) == "W")
                $direction = -1;

            $minutes = floor($dec_minutes);
            $seconds = 60 * ($dec_minutes - $minutes);

            $seconds = round($seconds, 5);

            $dms = $degrees . "º " . $minutes . "' " . $seconds . "\" " . $matches[3];
            return $dms;
        }
        else {
            return false;
        }
    }
}
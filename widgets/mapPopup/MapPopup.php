<?php

namespace app\widgets\mapPopup;

use yii\base\Widget;
use yii\web\View;
use kartik\icons\Icon;
use app\widgets\mapPopup\assets\MapPopupAsset;
use app\helpers\TimsHelper;


/**
 * MapPopup class implements the mapPopup widget to handle map view.
 * @author Vitalii Fokov
 */

class MapPopup extends Widget
{
    public $text;
    public $latitude;
    public $longitude;
    public $modalId;

    public function init()
    {
        $this->modalId = 'modal-' .  $this->id;
        $this->registerScripts();
    }

    public function registerScripts()
    {
        MapPopupAsset::register($this->getView());
        $latitude = TimsHelper::convertDMSToDecimal($this->latitude);
        $longitude = TimsHelper::convertDMSToDecimal($this->longitude);
        $this->getView()->registerJs("
            var myCenter = new google.maps.LatLng(\"{$latitude}\", \"{$longitude}\");

            function initialize()
            {
                var mapProp = {
                    center:myCenter,
                    zoom:5,
                    mapTypeId:google.maps.MapTypeId.ROADMAP
                };
                var map=new google.maps.Map(document.getElementById(\"googleMap\"),mapProp);
                var marker=new google.maps.Marker({
                    position:myCenter,
                });
                marker.setMap(map);
                var infowindow = new google.maps.InfoWindow({
                    content: 'Place Location'
                });
                infowindow.open(map,marker);
            }

            jQuery(function(){
                $('#{$this->modalId}').on('shown.bs.modal', function () {
                    initialize();
                });
            });
        ", View::POS_END, 'my-options');
    }

    public function run()
    {
        $icon = Icon::show('globe', ['class' => 'fa-3x']);

        return $this->render('index', [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'modalId' => $this->modalId,
            'icon' => $icon,
            'text' => $this->text,
        ]);
    }

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
}
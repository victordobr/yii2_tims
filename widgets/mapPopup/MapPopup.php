<?php

namespace app\widgets\mapPopup;

use yii\base\Widget;
use yii\web\View;
use kartik\icons\Icon;
use app\widgets\mapPopup\assets\MapPopupAsset;


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
        $this->getView()->registerJs("
            var myCenter = new google.maps.LatLng(\"{$this->latitude}\", \"{$this->longitude}\");

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
}
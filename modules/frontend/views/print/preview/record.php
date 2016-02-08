<?php
/*
 *
 */

use app\helpers\TimsHelper;

$this->registerJs(
    "function initialize_$model->id()
    {

        var myCenter=new google.maps.LatLng(" . TimsHelper::convertDMSToDecimal($model->lat) . "," . TimsHelper::convertDMSToDecimal($model->lng) . ");

        var mapProp = {
            center:myCenter,
            zoom:9,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };

        var map=new google.maps.Map(document.getElementById(\"google-map-$model->id\"),mapProp);

        var marker=new google.maps.Marker({
            position:myCenter,
        });

        marker.setMap(map);
    }

    google.maps.event.addDomListener(window, 'load', initialize_$model->id);",
    \yii\web\View::POS_END, 'google-map-' . $model->id);

?>

<div class="print-record">

    <div class="head">
        CLARK COUNTY SCHOOL DISTRICT<br>
        TRANSPORATION DEPARTMENT<br>
        4499 Arville St.<br>
        Las Vegas, NV 89103<br>
        Stop Arm Violation<br>
        NRS 484.357
    </div>
    <br>
    <div>
        <span
            class="bold">Date Time:</span>  <?= Yii::$app->formatter->asDatetime("$model->infraction_date", "php:d-m-Y H:i:s"); ?></span>
        <br/>
        <span class="bold">License Plate Number:</span> <?= $model->license; ?>
        <br/>
        <span class="bold">State:</span> <?= \app\enums\States::labelById($model->state_id); ?>

        <br>

        <?php if (isset($model->owner)): ?>
            <span class="bold">Vehicle Make Model:</span> <?= $model->owner->vehicleName; ?>,<br/>
            <span
                class="bold">Vehicle Color:</span><?= \app\enums\VehicleColors::labelById($model->owner->vehicle_color_id); ?>
            <br>
        <?php endif; ?>

    </div>
    <br>
    <table width="100%" cellspacing="5" border="0" class="media">
        <tbody>
        <tr>
            <td>Plate Image
            </td>
            <td>Overview Image
            </td>
            <td>Location
            </td>
        </tr>
        <tr>
            <td><img width="200" height="200" alt="n/a" src="<?= $model->imageOverviewCamera->url; ?>"></td>
            <td><img width="200" height="200" alt="n/a" src="<?= $model->imageLpr->url; ?>"></td>
            <td>
                <div id="google-map-<?= $model->id ?>" style="width:300px;height:250px;"></div>
            </td>
        </tr>
        </tbody>
    </table>
    <br>
    <div class="center bold">Do not submit incomplete forms</div>
    <br>

    <br>
    <div class="center bold">Submit all completed form to Ruth Hietbrink-Wallace Yard</div>

    <div class="page"></div>

</div>





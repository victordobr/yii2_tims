<?php

namespace app\modules\frontend\controllers\records\action;

use app\helpers\GpsHelper;
use app\models\Location;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;
use yii\web\Response;
use app\models\Record;

class UpdateAction extends Action
{
    public $record;
    public $location;

    /**
     * @param $id
     * @return mixed
     */
    public function run($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user = Yii::$app->user;
        $record = Record::findOne($id);
        /**
         * @var Location $location
         */
        $location = $record->location;
        $message = [];

        if (!empty($this->record['status_id'])) {
            if(self::record()->updateStatus($record->id, $user->id, $this->record['status_id'])){
                $message['success'] = Yii::t('app', 'Record status updated');
            } else {
                $message['info'] = Yii::t('app', 'Record status is not updated');
            }
        }

        if (!empty($this->location)) {
            $location->setAttributes($this->location);
            if (!$location->getDirtyAttributes()) {
                $message['info'] = Yii::t('app', 'Location attributes is not updated');
            } elseif (!$location->validate()) {
                $message['error'] = Yii::t('app', 'Location attributes is not valid');
            } else {
                $location->lat_dd = GpsHelper::convertDDMToDecimal($location->lat_ddm);
                $location->lng_dd = GpsHelper::convertDDMToDecimal($location->lng_ddm);
                $location->lat_dms = GpsHelper::convertDDMToDMS($location->lat_ddm);
                $location->lng_dms = GpsHelper::convertDDMToDMS($location->lng_ddm);
                $location->save(false);
                $message['success'] = Yii::t('app', 'Location attributes updated');
            }
        }

        return $message;
    }

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

    /**
     * @return RecordsController
     */
    private static function controller()
    {
        return Yii::$app->controller;
    }

}
<?php

namespace app\modules\frontend\controllers\records;

use app\enums\CaseStatus;
use app\models\Location;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;
use yii\web\Response;
use app\models\Record;

class UpdateAction extends Action
{
    public $attributes;

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
        $status = '';
        $errors = [];

        if (!empty($this->attributes['status_id'])) {
            if (self::record()->updateStatus($record->id, $user->id, $this->attributes['status_id'])) {
                $list = CaseStatus::listMainText();
                $status = $list[$this->attributes['status_id']];
            }
        }

        if (!empty($this->attributes['location'])) {
            $location->setAttributes($this->attributes['location']);
            if ($location->getDirtyAttributes()) {
                if (!$location->save()) {
                    $errors = $location->getErrors();
                }
            }
        }

        return [
            'status' => $status,
            'errors' => $errors,
        ];
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
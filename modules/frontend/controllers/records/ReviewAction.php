<?php

namespace app\modules\frontend\controllers\records;

use app\widgets\record\timeline\Timeline;
use Yii;
use app\enums\CaseStatus;
use app\models\Record;
use app\modules\frontend\controllers\RecordsController;
use app\modules\frontend\models\form\DeactivateForm;
use app\modules\frontend\models\form\RequestDeactivateForm;
use yii\base\Action;
use yii\helpers\Url;

class ReviewAction extends Action
{
    public function init()
    {
        parent::init();
        $this->controller()->layout = 'two-columns';
    }

    public function run($id = 0)
    {
        if (!$id) {
            $this->controller()->redirect(['search']);
        }

        $record = $this->controller()->findModel(Record::className(), $id);

        $history = [];
        $formatter = Yii::$app->formatter;
        foreach ($record->statusHistory as $status) {
            $history[$status->status_code] = [
                'label' => $status->status_code,
                'date' => $formatter->asDate($status->created_at, 'php:d M Y'),
            ];
        }
        Yii::$app->view->params['aside'] = Timeline::widget(['history' => $history]);

        return $this->controller()->render('review', [
            'model' => $record,
            'form' => $this->getForm($record),
        ]);
    }

    /**
     * @param Record $record
     * @return string
     */
    private function getForm(Record $record)
    {
        $user = Yii::$app->user;
        switch (true) {
            case $record->status_id == CaseStatus::AWAITING_DEACTIVATION && $user->can('ApproveDeactivation'):
                $model = new DeactivateForm();
                $model->record_id = $record->id;

                return $this->controller()->renderPartial('../forms/deactivate', [
                    'action' => Url::to(['deactivate', 'id' => $record->id]),
                    'model' => $model
                ]);
            case $record->status_id == CaseStatus::COMPLETE && $user->can('RequestDeactivation'):
                $model = new RequestDeactivateForm();

                return $this->controller()->renderPartial('../forms/request-deactivation', [
                    'action' => Url::to(['RequestDeactivation', 'id' => $record->id]),
                    'model' => $model
                ]);
            default:
                return '';
        }
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }

}
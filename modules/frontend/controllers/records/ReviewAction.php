<?php

namespace app\modules\frontend\controllers\records;

use app\components\Settings;
use app\enums\CaseStage;
use app\widgets\record\timeline\Timeline;
use Yii;
use app\enums\CaseStatus;
use app\modules\frontend\models\base\Record;
use app\modules\frontend\controllers\RecordsController;
use app\modules\frontend\models\form\DeactivateForm;
use app\modules\frontend\models\form\RequestDeactivateForm;
use yii\base\Action;
use yii\helpers\Url;
use app\enums\Reasons;

class ReviewAction extends Action
{
    public function init()
    {
        parent::init();
        $this->setLayout('two-columns');
    }

    public function run($id = 0)
    {
        if (!$id) {
            $this->controller()->redirect(['search']);
        }

        $record = $this->controller()->findModel(Record::className(), $id);

        $this->setPageTitle($record->id);

        Yii::$app->view->params['aside'] = Timeline::widget([
            'stages' => self::collectCaseStages($record),
            'remaining' => self::calculateRemainingDays($record)
        ]);

        return $this->controller()->render('review', [
            'model' => $record,
            'form' => $this->getForm($record),
        ]);
    }

    /**
     * @param Record $record
     * @return array
     */
    private static function collectCaseStages(Record $record)
    {
        $formatter = Yii::$app->formatter;
        return [
            CaseStage::SET_INFRACTION_DATE => $record->infraction_date,
            CaseStage::DATA_UPLOADED => $formatter->asDate($record->created_at, 'php:d M Y'),
        ];
    }

    /**
     * @param Record $record
     * @return int remaining days
     */
    private static function calculateRemainingDays(Record $record)
    {
        $infraction_date = new \DateTime(date('Y-m-d', $record->infraction_date));

        return self::settings()->get('case.lifetime') -(new \DateTime())->diff($infraction_date)->format('%a');
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

                $model = new DeactivateForm(['record_id' => $record->id]);
                $reasonsList = Reasons::listReasonsRejectingDeactivationRequest();

                return $this->controller()->renderPartial('../forms/deactivate', [
                    'action' => Url::to(['deactivate', 'id' => $record->id]),
                    'model' => $model,
                    'reasonsList' => $reasonsList,
                ]);
            case in_array($record->status_id, [CaseStatus::COMPLETE, CaseStatus::FULL_COMPLETE]) && $user->can('RequestDeactivation'):

                $model = new RequestDeactivateForm();
                $reasonsList = Reasons::listReasonsRequestDeactivation();

                return $this->controller()->renderPartial('../forms/request-deactivation', [
                    'action' => Url::to(['RequestDeactivation', 'id' => $record->id]),
                    'model' => $model,
                    'reasonsList' => $reasonsList,
                ]);
            default:
                return '';
        }
    }

    private function setPageTitle($record_id)
    {
        $title = Yii::t('app', 'View uploaded record - Case #' . $record_id);

        return $this->controller()->view->title = $title;
    }

    /**
     * @return Settings
     */
    private static function settings()
    {
        return Yii::$app->settings;
    }

    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }

}
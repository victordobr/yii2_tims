<?php

namespace app\modules\frontend\controllers\records;

use app\components\RbacUser;
use app\components\Settings;
use app\enums\CaseStage;
use app\enums\Role;
use app\models\User;
use app\modules\frontend\models\form\ChangeDeterminationForm;
use app\modules\frontend\models\form\MakeDeterminationForm;
use app\modules\frontend\Module;
use app\widgets\record\timeline\Timeline;
use app\widgets\record\update\UpdateButton;
use Yii;
use app\enums\CaseStatus;
use app\models\Record;
use app\modules\frontend\controllers\RecordsController;
use app\modules\frontend\models\form\DeactivateForm;
use app\modules\frontend\models\form\RequestDeactivateForm;
use yii\base\Action;
use yii\helpers\Url;
use app\enums\Reasons;

class ViewAction extends Action
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

        $user = Yii::$app->user;
        $record = $this->findModel($id);

        if (!Module::isCurrentTab('update') && $record->status_id < CaseStatus::VIEWED_RECORD) {
            if ($user->hasRole([Role::ROLE_SYSTEM_ADMINISTRATOR, Role::ROLE_POLICE_OFFICER, Role::ROLE_ROOT_SUPERUSER])) {
                self::record()->view($record->id, $user->id);
            }
        }

        $this->setPageTitle($record->id);
        $this->setAside($record);

        return $this->controller()->render(self::getView($user), [
            'model' => $record,
            'form' => $this->renderForm($record),
            'statuses' => CaseStatus::listCodeDescription(),
        ]);
    }

    private static function getView(RbacUser $user)
    {
        switch (Module::getTab()) {
            case 'search':
                $view = !$user->hasRole([
                    Role::ROLE_OPERATIONS_MANAGER,
                    Role::ROLE_SYSTEM_ADMINISTRATOR,
                    Role::ROLE_ROOT_SUPERUSER,
                ]) ? 'basic' : 'advanced';
                return 'view/' . $view;
            case 'review':
                return 'view/basic';
            case 'print':
                return 'view/advanced';
            case 'update':
                return 'view/editable';
            default:
                return 'view/error';
        }
    }

    /**
     * @param Record $record
     * @return string
     */
    private function renderForm(Record $record)
    {
        $user = Yii::$app->user;

        switch (true) {
            case in_array($record->status_id, [CaseStatus::COMPLETE, CaseStatus::FULL_COMPLETE]) && $user->can('RequestDeactivation'):
                return $this->controller()->renderPartial('../forms/request-deactivation', [
                    'action' => Url::to(['RequestDeactivation', 'id' => $record->id]),
                    'model' => new RequestDeactivateForm(),
                    'reasonsList' => Reasons::listReasonsRequestDeactivation(),
                ]);
            case $record->status_id == CaseStatus::AWAITING_DEACTIVATION && $user->can('ApproveDeactivation'):
                return $this->controller()->renderPartial('../forms/deactivate', [
                    'action' => Url::to(['deactivate', 'id' => $record->id]),
                    'model' => new DeactivateForm(['record_id' => $record->id]),
                    'reasonsList' => Reasons::listReasonsRejectingDeactivationRequest(),
                ]);
            case $record->status_id == CaseStatus::VIEWED_RECORD && $user->can('MakeDetermination'):
                $userModel = User::findOne(Yii::$app->user->id);
                return $this->controller()->renderPartial('../forms/make-determination', [
                    'action' => Url::to(['MakeDetermination', 'id' => $record->id]),
                    'model' => new MakeDeterminationForm([
                        'currentOfficerPin' => $userModel->officer_pin,
                    ]),
                    'reasons' => Reasons::listReasonsRejectingCase(),
                ]);
            case in_array($record->status_id, [CaseStatus::APPROVED_RECORD, CaseStatus::REJECTED_RECORD]) && $user->can('ChangeDetermination'):
                $userModel = User::findOne(Yii::$app->user->id);
                return $this->controller()->renderPartial('../forms/change-determination', [
                    'action' => Url::to(['ChangeDetermination', 'id' => $record->id]),
                    'model' => new ChangeDeterminationForm([
                        'record_id' => $record->id,
                        'record_status' => $record->status_id,
                        'currentOfficerPin' => $userModel->officer_pin,
                    ]),
                    'reasons' => Reasons::listReasonsRejectingCase(),
                ]);
            default:
                return '';
        }
    }

    /**
     * @param Record $record
     * @return string
     * @throws \Exception
     */
    private function setAside(Record $record)
    {
        $aside = Timeline::widget([
            'stages' => self::collectCaseStages($record),
            'remaining' => self::calculateRemainingDays($record)
        ]);

        if (Module::isCurrentTab('update')) {
            $aside .= UpdateButton::widget([
                'elements' => [
                    '#case-details' => ['select'],
                    '#photo-video-evidence' => ['input'],
                ]
            ]);
        }

        return Yii::$app->view->params['aside'] = $aside;
    }

    /**
     * @param Record $record
     * @return array
     */
    private static function collectCaseStages(Record $record)
    {
        $formatter = Yii::$app->formatter;
        return [
            CaseStage::SET_INFRACTION_DATE => $formatter->asDate($record->infraction_date, 'php:d M Y'),
            CaseStage::DATA_UPLOADED => $formatter->asDate($record->created_at, 'php:d M Y'),
            CaseStage::VIOLATION_APPROVED => !empty($record->approved_at) ?
                $formatter->asDate($record->approved_at, 'php:d M Y') : null,
            CaseStage::DMV_DATA_REQUEST => !empty($record->dmv_received_at) ?
                $formatter->asDate($record->dmv_received_at, 'php:d M Y') : null,
            CaseStage::CITATION_PRINTED => !empty($record->printed_at) ?
                $formatter->asDate($record->printed_at, 'php:d M Y') : null,
            CaseStage::CITATION_QC_VERIFIED => !empty($record->qc_verified_at) ?
                $formatter->asDate($record->qc_verified_at, 'php:d M Y') : null,
        ];
    }

    /**
     * @param Record $record
     * @return int remaining days
     */
    private static function calculateRemainingDays(Record $record)
    {
        $infraction_date = new \DateTime($record->infraction_date);

        return self::settings()->get('case.lifetime') - (new \DateTime())->diff($infraction_date)->format('%a');
    }

    /**
     * @param $id
     * @return Record
     * @throws \yii\web\NotFoundHttpException
     */
    private function findModel($id)
    {
        return $this->controller()->findModel(Record::className(), $id);
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

    /**
     * @param string $name
     */
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

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

}
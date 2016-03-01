<?php

namespace app\modules\frontend\controllers\records;

use app\components\Settings;
use app\enums\CaseStage;
use app\enums\MenuTab;
use app\enums\Role;
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
use app\components\Record as RecordComponent;

class ViewAction extends Action
{
    const MODE_UNDEFINED = 0;
    const MODE_BASIC = 1;
    const MODE_ADVANCED = 2;
    const MODE_EDITABLE = 3;

    private $mode = self::MODE_UNDEFINED;

    public function init()
    {
        parent::init();
        $this->setLayout('two-columns');
    }

    public function beforeRun()
    {
        $this->initMode();
        return parent::beforeRun();
    }

    public function run($id = 0)
    {
        if (!$id) {
            $this->controller()->redirect(['search']);
        }

        $user = Yii::$app->user;
        $record = $this->findModel($id);

        if (Module::isCurrentTab(MenuTab::TAB_REVIEW) && in_array($record->status_id, [CaseStatus::COMPLETE, CaseStatus::FULL_COMPLETE])) {
            if ($user->hasRole([Role::ROLE_SYSTEM_ADMINISTRATOR, Role::ROLE_POLICE_OFFICER, Role::ROLE_ROOT_SUPERUSER])) {
                self::record()->view($record->id, $user->id);
                $record->refresh();
            }
        }

        $this->setPageTitle($record->id);
        $this->setAside($record);

        return $this->controller()->render($this->getView(), [
            'model' => $record,
            'form' => $this->renderForm($record),
            'statuses' => CaseStatus::listCodeDescription(),
        ]);
    }

    /**
     * @return string
     */
    private function getView()
    {
        switch ($this->mode) {
            case self::MODE_BASIC:
                return 'view/basic';
            case self::MODE_ADVANCED:
                return 'view/advanced';
            case self::MODE_EDITABLE:
                return 'view/editable';
            default:
                return 'view/error';
        }
    }

    /**
     * @return int|null
     */
    private function initMode()
    {
        switch (Module::getTab()) {
            case MenuTab::TAB_SEARCH:
                $advanced = Yii::$app->user->hasRole([
                    Role::ROLE_OPERATIONS_MANAGER,
                    Role::ROLE_SYSTEM_ADMINISTRATOR,
                    Role::ROLE_ROOT_SUPERUSER,
                ]);
                return $this->mode = !$advanced ? self::MODE_BASIC : self::MODE_ADVANCED;
            case MenuTab::TAB_REVIEW:
                return $this->mode = self::MODE_BASIC;
            case MenuTab::TAB_UPDATE:
                return $this->mode = self::MODE_EDITABLE;
            default:
                return null;
        }
    }

    /**
     * @return bool
     */
    private function isEditableMode()
    {
        return $this->mode == self::MODE_EDITABLE;
    }

    /**
     * @param string $name
     */
    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    /**
     * @param int $record_id
     * @return string
     */
    private function setPageTitle($record_id)
    {
        $title = !$this->isEditableMode()?
            Yii::t('app', 'View record - Case #' . $record_id):
            Yii::t('app', 'Update record - Case #' . $record_id);

        return $this->controller()->view->title = $title;
    }

    /**
     * @param Record $record
     * @return string
     */
    private function renderForm(Record $record)
    {
        $user = Yii::$app->user;

        switch (true) {
            // rev: call record component as self::record()
            case in_array($record->status_id, [CaseStatus::COMPLETE, CaseStatus::FULL_COMPLETE]) && $user->can('RequestDeactivation') && RecordComponent::checkDeactivateTimeout($record->created_at):
                return $this->controller()->renderPartial('../forms/request-deactivation', [
                    'action' => Url::to(['RequestDeactivation', 'id' => $record->id]),
                    'model' => new RequestDeactivateForm(),
                    'reasonsList' => Reasons::listReasonsRequestDeactivation(),
                ]);
            // rev: call record component as self::record()
            case $record->status_id == CaseStatus::AWAITING_DEACTIVATION && $user->can('ApproveDeactivation') && RecordComponent::checkDeactivateTimeout($record->created_at):
                return $this->controller()->renderPartial('../forms/deactivate', [
                    'action' => Url::to(['deactivate', 'id' => $record->id]),
                    'model' => new DeactivateForm(['record_id' => $record->id]),
                    'reasonsList' => Reasons::listReasonsRejectingDeactivationRequest(),
                ]);
            case $record->status_id == CaseStatus::VIEWED_RECORD && $user->can('MakeDetermination'):
                return $this->controller()->renderPartial('../forms/make-determination', [
                    'action' => Url::to(['MakeDetermination', 'id' => $record->id]),
                    'model' => new MakeDeterminationForm([
                        'currentOfficerPin' => $user->identity->officer_pin,
                    ]),
                    'reasons' => Reasons::listReasonsRejectingCase(), // todo: change list of reasons
                ]);
            // rev: call record component as self::record()
            case in_array($record->status_id, [CaseStatus::APPROVED_RECORD, CaseStatus::REJECTED_RECORD]) && $user->can('ChangeDetermination') && RecordComponent::checkChangeDeterminationTimeout($record->created_at):
                return $this->controller()->renderPartial('../forms/change-determination', [
                    'action' => Url::to(['ChangeDetermination', 'id' => $record->id]),
                    'model' => new ChangeDeterminationForm([
                        'record_id' => $record->id,
                        'record_status' => $record->status_id,
                        'currentOfficerPin' => $user->identity->officer_pin,
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

        if ($this->isEditableMode()) {
            $aside .= UpdateButton::widget([
                'wrapper' => '#record-editable-view',
                'forms' => [
                    '#form-case-details',
                    '#form-photo-video-evidence',
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

    /**
     * @return Settings
     */
    private static function settings()
    {
        return Yii::$app->settings;
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
<?php

namespace app\widgets\record\timeline;

use app\enums\CaseStage as Stage;
use Yii;
use yii\base\Widget;
use app\widgets\record\timeline\assets\TimelineAsset;

class Timeline extends Widget
{
    private $timeline = [];

    public $history;

    public function init()
    {
        TimelineAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', ['timeline' => $this->initTimeline()]);
    }

    private function initTimeline()
    {
        if (!$this->timeline) {
            $pending = Yii::t('app', 'Pending');
            $this->timeline = [
                Stage::SET_INFRACTION_DATE => [
                    'is_done' => !empty($this->history[Stage::SET_INFRACTION_DATE]),
                    'label' => Yii::t('app', 'Infraction Date'),
                    'date' => !empty($this->history[Stage::SET_INFRACTION_DATE]) ?
                        $this->history[Stage::SET_INFRACTION_DATE]['date'] : $pending
                ],
                Stage::DATA_UPLOADED => [
                    'is_done' => !empty($this->history[Stage::DATA_UPLOADED]),
                    'label' => Yii::t('app', 'Data Uploaded'),
                    'date' => !empty($this->history[Stage::DATA_UPLOADED]) ?
                        $this->history[Stage::DATA_UPLOADED]['date'] : $pending
                ],
                Stage::VIOLATION_APPROVED => [
                    'is_done' => !empty($this->history[Stage::VIOLATION_APPROVED]),
                    'label' => Yii::t('app', 'Violation Approved'),
                    'date' => !empty($this->history[Stage::VIOLATION_APPROVED]) ?
                        $this->history[Stage::VIOLATION_APPROVED]['date'] : $pending
                ],
                Stage::DMV_DATA_REQUEST => [
                    'is_done' => false,
                    'label' => Yii::t('app', 'DMV Data'),
                    'date' => $pending
                ],
                Stage::CITATION_PRINTED => [
                    'is_done' => false,
                    'label' => Yii::t('app', 'Citation Printed'),
                    'date' => $pending
                ],
                Stage::CITATION_QC_VERIFIED => [
                    'is_done' => false,
                    'label' => Yii::t('app', 'Citation QC Verified'),
                    'date' => $pending
                ],
            ];
        }

        return $this->timeline;
    }

}
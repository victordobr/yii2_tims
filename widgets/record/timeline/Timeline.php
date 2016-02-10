<?php

namespace app\widgets\record\timeline;

use app\enums\CaseStage as Stage;
use Yii;
use yii\base\Widget;
use app\widgets\record\timeline\assets\TimelineAsset;

class Timeline extends Widget
{
    private $timeline = [];

    public $stages;
    public $remaining;

    public function init()
    {
        TimelineAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', [
            'timeline' => $this->initTimeline(),
            'remaining' => $this->remaining
        ]);
    }

    private function initTimeline()
    {
        if (!$this->timeline) {
            $pending = Yii::t('app', 'Pending');
            $this->timeline = [
                Stage::SET_INFRACTION_DATE => [
                    'is_done' => !empty($this->stages[Stage::SET_INFRACTION_DATE]),
                    'label' => Yii::t('app', 'Infraction Date'),
                    'date' => !empty($this->stages[Stage::SET_INFRACTION_DATE]) ?
                        $this->stages[Stage::SET_INFRACTION_DATE] : $pending
                ],
                Stage::DATA_UPLOADED => [
                    'is_done' => !empty($this->stages[Stage::DATA_UPLOADED]),
                    'label' => Yii::t('app', 'Data Uploaded'),
                    'date' => !empty($this->stages[Stage::DATA_UPLOADED]) ?
                        $this->stages[Stage::DATA_UPLOADED] : $pending
                ],
                Stage::VIOLATION_APPROVED => [
                    'is_done' => !empty($this->stages[Stage::VIOLATION_APPROVED]),
                    'label' => Yii::t('app', 'Violation Approved'),
                    'date' => !empty($this->stages[Stage::VIOLATION_APPROVED]) ?
                        $this->stages[Stage::VIOLATION_APPROVED] : $pending
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
<?php

namespace app\widgets\record\timeline;

use app\enums\CaseStatus;
use Yii;
use yii\base\Widget;
use app\widgets\record\timeline\assets\TimelineAsset;

class Timeline extends Widget
{
    const INFRACTION_DATE = 1;
    const DATA_UPLOADED = 2;
    const VIOLATION_APPROVED = 3;
    const DMV_DATA = 4;
    const CITATION_PRINTED = 5;
    const CITATION_QC_VERIFIED = 6;

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
                self::INFRACTION_DATE => [
                    'is_done' => !empty($this->history[CaseStatus::INCOMPLETE]),
                    'label' => Yii::t('app', 'Infraction Date'),
                    'date' => !empty($this->history[CaseStatus::INCOMPLETE]) ?
                        $this->history[CaseStatus::INCOMPLETE]['date'] : $pending
                ],
                self::DATA_UPLOADED => [
                    'is_done' => !empty($this->history[CaseStatus::COMPLETE]),
                    'label' => Yii::t('app', 'Data Uploaded'),
                    'date' => !empty($this->history[CaseStatus::COMPLETE]) ?
                        $this->history[CaseStatus::COMPLETE]['date'] : $pending
                ],
                self::VIOLATION_APPROVED => [
                    'is_done' => !empty($this->history[CaseStatus::DEACTIVATED_RECORD]),
                    'label' => Yii::t('app', 'Violation Approved'),
                    'date' => !empty($this->history[CaseStatus::DEACTIVATED_RECORD]) ?
                        $this->history[CaseStatus::DEACTIVATED_RECORD]['date'] : $pending
                ],
                self::DMV_DATA => [
                    'is_done' => false,
                    'label' => Yii::t('app', 'DMV Data'),
                    'date' => $pending
                ],
                self::CITATION_PRINTED => [
                    'is_done' => false,
                    'label' => Yii::t('app', 'Citation Printed'),
                    'date' => $pending
                ],
                self::CITATION_QC_VERIFIED => [
                    'is_done' => false,
                    'label' => Yii::t('app', 'Citation QC Verified'),
                    'date' => $pending
                ],
            ];
        }

        return $this->timeline;
    }

}
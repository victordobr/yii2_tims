<?php

namespace app\widgets\record\timeline;

use app\enums\CaseStage as Stage;
use Yii;
use yii\base\Widget;
use app\widgets\record\timeline\assets\TimelineAsset;

class Timeline extends Widget
{
    const DATE_ERROR = 0;

    const CLASS_STAGE_DONE = 'tl-done';
    const CLASS_STAGE_ERROR = 'tl-error';

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
            $this->timeline = [
                Stage::SET_INFRACTION_DATE => [
                    'class' => $this->getStageClass(Stage::SET_INFRACTION_DATE),
                    'label' => Yii::t('app', 'Infraction Date'),
                    'date' => $this->setStageDate(Stage::SET_INFRACTION_DATE),
                ],
                Stage::DATA_UPLOADED => [
                    'class' => $this->getStageClass(Stage::DATA_UPLOADED),
                    'label' => Yii::t('app', 'Data Uploaded'),
                    'date' => $this->setStageDate(Stage::DATA_UPLOADED),
                ],
                Stage::VIOLATION_APPROVED => [
                    'class' => $this->getStageClass(Stage::VIOLATION_APPROVED),
                    'label' => Yii::t('app', 'Violation Approved'),
                    'date' => $this->setStageDate(Stage::VIOLATION_APPROVED),
                ],
                Stage::DMV_DATA_REQUEST => [
                    'class' => $this->getStageClass(Stage::DMV_DATA_REQUEST),
                    'label' => Yii::t('app', 'DMV Data Request'),
                    'date' => $this->setStageDate(Stage::DMV_DATA_REQUEST),
                ],
                Stage::CITATION_PRINTED => [
                    'class' => $this->getStageClass(Stage::CITATION_PRINTED),
                    'label' => Yii::t('app', 'Citation Printed'),
                    'date' => $this->setStageDate(Stage::CITATION_PRINTED),
                ],
                Stage::CITATION_QC_VERIFIED => [
                    'class' => $this->getStageClass(Stage::CITATION_QC_VERIFIED),
                    'label' => Yii::t('app', 'Citation QC Verified'),
                    'date' => $this->setStageDate(Stage::CITATION_QC_VERIFIED),
                ],
                Stage::CASE_CLOSED => [
                    'class' => false,
                    'label' => Yii::t('app', 'Case Closed'),
                    'date' => $this->setStageDate(Stage::CASE_CLOSED),
                ],
            ];
        }

        return $this->timeline;
    }

    /**
     * @param int $stage
     * @return string
     */
    private function getStageClass($stage)
    {
        if ($stage == Stage::DMV_DATA_REQUEST && $this->stages[$stage] === self::DATE_ERROR) {
            $this->stages[$stage] = Yii::t('app', 'Error');

            return self::CLASS_STAGE_ERROR;
        }

        return !empty($this->stages[$stage]) ? self::CLASS_STAGE_DONE : '';
    }

    /**
     * @param int $stage
     * @return string
     */
    private function setStageDate($stage)
    {
        if (!empty($this->stages[$stage])) {
            return $this->stages[$stage];
        }

        static $pending;
        if (!$pending) {
            $pending = Yii::t('app', 'Pending');
        }

        return $pending;
    }

}
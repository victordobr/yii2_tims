<?php

namespace app\widgets\record\filter;

use app\modules\frontend\models\search\Record;
use Yii;
use yii\base\Widget;
use app\widgets\record\filter\assets\FilterAsset;

class Filter extends Widget
{
    const ACTION_SEARCH = 'search';
    const ACTION_PRINT = 'print';
    const ACTION_QC = 'qc';

    public $action;
    public $model;

    public function init()
    {
        FilterAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', [
            'filters' => [
                'statuses' => $this->byStatuses(),
                'uploader' => $this->byUploader(),
            ],
            'model' => $this->model
        ]);
    }

    private function byUploader()
    {
        return $this->action == self::ACTION_SEARCH;
    }

    private function byStatuses()
    {
        switch ($this->action) {
            case self::ACTION_SEARCH:
                return [
                    [
                        'name' => 'filter_status[]',
                        'label' => Yii::t('app', 'Show only incomplete records'),
                        'value' => Record::STATUS_INCOMPLETE,
                    ],
                    [
                        'name' => 'filter_status[]',
                        'label' => Yii::t('app', 'Show only records within deactivation window'),
                        'value' => Record::STATUS_COMPLETE_WITH_DEACTIVATION_WINDOW,
                    ],
                ];
            case self::ACTION_PRINT:
                return [
                    [
                        'name' => 'filter_status[]',
                        'label' => Yii::t('app', 'Show only records pending print Period 1'),
                        'value' => Record::STATUS_PRINT_P1,
                    ],
                    [
                        'name' => 'filter_status[]',
                        'label' => Yii::t('app', 'Show only records pending reprint (QC failed)'),
                        'value' => Record::STATUS_RE_PRINT,
                    ],
                ];
            case self::ACTION_QC:
                return [
                    [
                        'name' => 'filter_status[]',
                        'label' => Yii::t('app', 'Show only records pending print Period 1'),
                        'value' => Record::STATUS_PRINT_P1,
                    ],
                ];
            default:
                return [];
        }
    }

}
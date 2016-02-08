<?php

namespace app\widgets\record\filter;

use app\enums\Role;
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
    public $role;
    public $model;

    public function init()
    {
        FilterAsset::register($this->getView());
    }

    function run()
    {
        return $this->render('index', [
            'filters' => [
                'statuses' => $this->getStatusFilters(),
                'uploader' => $this->getUploaderFilter(),
                'reviewed' => $this->getReviewerFilter(),
            ],
            'model' => $this->model
        ]);
    }

    private function isUser(array $roles)
    {
        return in_array($this->role, $roles);
    }

    private function getReviewerFilter()
    {
        return $this->isUser([Role::ROLE_POLICE_OFFICER]);
    }

    private function getUploaderFilter()
    {
        return $this->isUser([
            Role::ROLE_VIDEO_ANALYST,
            Role::ROLE_VIDEO_ANALYST_SUPERVISOR,
            Role::ROLE_PRINT_OPERATOR
        ]) && $this->action == self::ACTION_SEARCH;
    }

    private function getStatusFilters()
    {
        switch (true) {
            case $this->isUser([
                    Role::ROLE_VIDEO_ANALYST,
                    Role::ROLE_VIDEO_ANALYST_SUPERVISOR,
                    Role::ROLE_PRINT_OPERATOR]
            ):
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
                }
                break;
            case $this->isUser([Role::ROLE_POLICE_OFFICER]):
                return [
                    [
                        'name' => 'filter_status[]',
                        'label' => Yii::t('app', 'Show only viewed cases without a determination'),
                        'value' => Record::STATUS_PRINT_P1,
                    ],
                    [
                        'name' => 'filter_status[]',
                        'label' => Yii::t('app', 'Show only cases within change window'),
                        'value' => Record::STATUS_RE_PRINT,
                    ],
                ];
        }

        return [];
    }

}
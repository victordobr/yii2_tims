<?php

namespace app\modules\frontend\controllers\reports;

use app\assets\ReportAsset;
use app\enums\ReportGroup;
use app\enums\ReportType;
use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\summary\Record as SummaryRecordSearch;
use app\widgets\report\filters\Filters;
use kartik\helpers\Html;
use pheme\settings\Module;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;
use app\enums\CaseStatus as Status;

class SummaryReportAction extends Action
{
    public $attributes;

    public function init()
    {
        parent::init();
        $this->setLayout('two-columns');
        ReportAsset::register($this->controller()->getView());
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run($group)
    {
        $title = ReportType::labelById(ReportType::SUMMARY_REPORT_VIOLATIONS_BY_DATE);
        $this->setPageTitle($title);

        $this->setPageDateRange($this->attributes['filter_created_at_from'], $this->attributes['filter_created_at_to']);
//        $this->setPageGroupBy($filter_group_id);

        $model = new SummaryRecordSearch();


        $model->filter_group_id = ReportGroup::getIdByUrl($group);

        $dataProvider = $model->search($this->attributes);


        $model->getAttributeLabel($model->filter_group_id);
//        \app\base\Module::pa($model->getAttributeLabel($model->filter_group_id),1);
        $this->setAside($model, 2);


//        $groups = Status::listGroupsReport();
//        $hierarchy = ;
        $groupAttribute = ReportGroup::getGroupAttribute($model->filter_group_id);

        $headerGroup = [
            'content' => Status::listGroupsReport(),
            'colspan' => Status::getHierarchyReport(),
        ];
//        \app\base\Module::pa($listColumn,1);
        return $this->controller()->render('summary', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'headerGroup' => $headerGroup,
            'groupAttribute' => $groupAttribute,
        ]);
    }

    /**
     * RecordFilter $model
     * @param RecordFilter $model
     * @return string
     * @throws \Exception
     */
    private function setAside($model,  $mode)
    {
        return Yii::$app->view->params['aside'] = Filters::widget([
            'model' => $model,
            'mode' => $mode,
        ]);
    }

    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    private function setPageTitle($title)
    {
        return $this->controller()->view->title = $title;
    }

    private function setPageDateRange($date_from, $date_to)
    {
        if (empty($date_from) && empty($date_to)) {
            return $this->controller()->view->params['date_range'] = '';
        }

        $from = Yii::$app->formatter->asDate($date_from, 'medium');
        $to = Yii::$app->formatter->asDate($date_to, 'medium');
        switch (true) {
            case !empty($from) && !empty($to):
                $interval = date('j', strtotime($to)) - date('j', strtotime($from));
                $content = Yii::t('app', 'Date range: {from} to {to} ({days,plural,=0{one day} =1{one day} other{# days}})', [
                    'from' => $from,
                    'to' => $to,
                    'days' => $interval,
                ]);
                break;
            case !empty($from):
                $content = Yii::t('app', 'Date range: add days from {from}', [
                    'from' => $from,
                ]);
                break;
            case !empty($to):
                $content = Yii::t('app', 'Date range: add days to {to}', [
                    'to' => $to,
                ]);
                break;
        }

        return $this->controller()->view->params['date_range'] = Html::tag('h4', $content, ['align' => 'center']);
    }

    private function setPageGroupBy($group_by)
    {
        if (empty($group_by)) {
            return $this->controller()->view->params['filter_group_id'] = '';
        }

        return $this->controller()->view->params['filter_group_id'] = $group_by;
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }
}
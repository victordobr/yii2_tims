<?php

namespace app\modules\frontend\controllers\reports;

use app\enums\ReportType;
use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\search\Record as RecordSearch;
use app\widgets\report\filters\Filters;
use kartik\base\Module;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class SummaryReportDashboardViewAction extends Action
{
    public $attributes;

    public function init()
    {
        parent::init();
        $this->setLayout('two-columns');
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $title = ReportType::labelById(ReportType::SUMMARY_REPORT_DASHBOARD_VIEW);
        $this->setPageTitle($title);

        $model = new RecordSearch();

        $dataProvider = $model->search($this->attributes);

        $this->setAside($model, 2);

        return $this->controller()->render('summaryReportDashboardView', [
            'model' => $model,
//            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * RecordFilter $model
     * @param $model
     * @param $mode
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
        $title = Yii::t('app', $title);

        return $this->controller()->view->title = $title;
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }
}
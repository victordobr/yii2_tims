<?php

namespace app\modules\frontend\controllers\reports;

use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\search\Record as RecordSearch;
use app\widgets\report\filters\Filters;
use kartik\base\Module;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class OverallSummaryDashboardAction extends Action
{
    public $attributes;

    public function init()
    {
        parent::init();
        $this->setLayout('two-column');
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $this->setPageTitle('OverallSummaryDashboard');

        $model = new RecordSearch();

        $dataProvider = $model->search($this->attributes);

        return $this->controller()->render('violationsByDate', [
            'model' => $model,
            'dataProvider' => $dataProvider,
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
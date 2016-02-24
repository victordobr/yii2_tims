<?php

namespace app\modules\frontend\controllers\reports;

use app\assets\ReportAsset;
use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\Record;
use app\widgets\record\filterReport\FilterReport;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class ReportViewAction extends Action
{
    public $attributes;

    public function init()
    {
        parent::init();
        $this->setLayout('two-columns');
    }

    public function beforeRun()
    {
        $view = $this->controller()->getView();
        ReportAsset::register($view);
        return true;
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $this->setPageTitle();

        $queryParams = Yii::$app->request->getQueryParams();

        $this->attributes['status_id'] = $queryParams['id'];

        if (!empty($queryParams['created_from'])) {
            $this->attributes['filter_created_at_from'] = $queryParams['created_from'];
        }
        if (!empty($queryParams['created_to'])) {
            $this->attributes['filter_created_at_to'] = $queryParams['created_to'];
        }

        $model = new Record();

        $dataProvider = $model->search($this->attributes);
        $this->setAside($model);

        return $this->controller()->render('view', [
            'provider' => $dataProvider,
        ]);

    }

    /**
     * RecordFilter $model
     * @param RecordFilter $model
     * @return string
     * @throws \Exception
     */
    private function setAside(RecordFilter $model)
    {
        return Yii::$app->view->params['aside'] = FilterReport::widget([
            'model' => $model,
            'action' => Yii::$app->controller->action->id,
        ]);
    }

    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    private function setPageTitle()
    {
        $title = Yii::t('app', 'Report');

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
<?php

namespace app\modules\frontend\controllers\reports;

use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\search\Record as RecordSearch;
use app\widgets\record\filterReport\FilterReport;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class ViolationsBySchoolBusAction extends Action
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
        $this->setPageTitle();

        $model = new RecordSearch();

        $dataProvider = $model->search($this->attributes);

        $this->setAside($model);

        return $this->controller()->render('violationsByDate', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * RecordFilter $model
     * @param RecordFilter $model
     * @return string
     * @throws \Exception
     */
    private function setAside($model)
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
        $title = Yii::t('app', 'Reports');

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
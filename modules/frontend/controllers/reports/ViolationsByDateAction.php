<?php

namespace app\modules\frontend\controllers\reports;

use app\assets\ReportAsset;
use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\search\Record as RecordSearch;
use app\widgets\record\filter\assets\FilterAsset;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class ViolationsByDateAction extends Action
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

        $model = new RecordSearch();

        $dataProvider = $model->search($this->attributes);

        return $this->controller()->render('ViolationsByDate', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param RecordFilter $model
     * @param bool $advanced_mode
     * @return string
     * @throws \Exception
     */
    private function setAside(RecordFilter $model, $advanced_mode)
    {
        return Yii::$app->view->params['aside'] = Filter::widget([
            'model' => $model,
            'advanced_mode' => $advanced_mode,
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
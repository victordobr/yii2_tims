<?php

namespace app\modules\frontend\controllers\reports;

use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\models\report\Record;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class ReportDetailsAction extends Action
{
    public $attributes;

    public function init()
    {
        parent::init();
        $this->setLayout('two-columns');
    }

//    public function beforeRun()
//    {
//        $view = $this->controller()->getView();
//        ReportAsset::register($view);
//        return true;
//    }

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

//        \app\base\Module::pa($params);


        $dataProvider = $model->search($this->attributes);



        return $this->controller()->render('ReportDetailsAction', [
            'provider' => $dataProvider,
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
        $title = Yii::t('app', 'Records');

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
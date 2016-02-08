<?php

namespace app\modules\frontend\controllers\records;

use app\widgets\record\filter\Filter;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;
use app\modules\frontend\models\search\Record as RecordSearch;

class SearchAction extends Action
{
    public function init()
    {
        parent::init();
        $this->controller()->layout = 'two-columns';
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $model = new RecordSearch;

        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->params['search.page.size'];

        Yii::$app->view->params['aside'] = Filter::widget(['action' => 'search', 'model' => $model]);

        return $this->controller()->render('search', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }

}
<?php

namespace app\modules\frontend\controllers\records;

use app\enums\Role;
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
        $this->setPageTitle();
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

        Yii::$app->view->params['aside'] = Filter::widget([
            'action' => 'search',
            'role' => Yii::$app->user->role->name,
            'model' => $model
        ]);

        return $this->controller()->render('search', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function setPageTitle()
    {
        switch (Yii::$app->user->role->name) {
            case Role::ROLE_VIDEO_ANALYST:
            case Role::ROLE_VIDEO_ANALYST_SUPERVISOR:
            case Role::ROLE_PRINT_OPERATOR:
                return $this->controller()->view->title = Yii::t('app', 'Search Panel - List of uploaded records');
            case Role::ROLE_POLICE_OFFICER:
                return $this->controller()->view->title = Yii::t('app', 'Search Panel - List of cases pending evidence review/determination');
        }
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }

}
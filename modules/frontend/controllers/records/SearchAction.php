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
    public $attributes;

    public function init()
    {
        parent::init();

        $this->setLayout('two-columns');
        $this->setPageTitle();
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $user = Yii::$app->user;
        $model = new RecordSearch;

        $provider = $model->search($this->attributes);

        Yii::$app->view->params['aside'] = Filter::widget([
            'action' => 'search',
            'role' => $user->role->name,
            'model' => $model
        ]);

        return $this->controller()->render('search', [
            'dataProvider' => $provider,
        ]);
    }

    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    private function setPageTitle()
    {
        $title = '';
        switch (Yii::$app->user->role->name) {
            case Role::ROLE_VIDEO_ANALYST:
            case Role::ROLE_VIDEO_ANALYST_SUPERVISOR:
            case Role::ROLE_PRINT_OPERATOR:
                $title = Yii::t('app', 'Search Panel - List of uploaded cases');
                break;
            case Role::ROLE_POLICE_OFFICER:
                $title = Yii::t('app', 'Search Panel - List of cases pending evidence review/determination');
                break;
        }

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
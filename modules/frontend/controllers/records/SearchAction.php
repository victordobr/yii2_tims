<?php

namespace app\modules\frontend\controllers\records;

use app\enums\Role;
use app\modules\frontend\models\search\Record;
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
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function run()
    {
        $this->setPageTitle();

        $user = Yii::$app->user;
        $model = new RecordSearch;

        $provider = $model->search($this->attributes);

        $this->setAside($model, $user->hasRole([
            Role::ROLE_OPERATIONS_MANAGER,
            Role::ROLE_SYSTEM_ADMINISTRATOR,
            Role::ROLE_ROOT_SUPERUSER,
        ]));

        return $this->controller()->render('search', [
            'dataProvider' => $provider,
        ]);
    }

    /**
     * @param RecordSearch $model
     * @param bool $advanced_mode
     * @return string
     * @throws \Exception
     */
    private function setAside(Record $model, $advanced_mode)
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
        $title = '';
        switch (Yii::$app->user->role->name) {
            case Role::ROLE_VIDEO_ANALYST:
            case Role::ROLE_SYSTEM_ADMINISTRATOR:
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
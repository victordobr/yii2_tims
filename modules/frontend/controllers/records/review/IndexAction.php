<?php

namespace app\modules\frontend\controllers\records\review;

use app\enums\Role;
use app\widgets\record\filter\Filter;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;
use app\modules\frontend\models\review\Record;

class IndexAction extends Action
{
    public $attributes;

    public function init()
    {
        parent::init();
        $this->setLayout('two-columns');
    }

    public function run()
    {
        $this->setPageTitle();

        $user = Yii::$app->user;
        $model = new Record;

        $provider = $model->search($this->attributes);

        $this->setAside($model, $user->hasRole([
            Role::ROLE_OPERATIONS_MANAGER,
            Role::ROLE_SYSTEM_ADMINISTRATOR,
            Role::ROLE_ROOT_SUPERUSER,
        ]));

        return $this->controller()->render('review/index', [
            'provider' => $provider,
        ]);
    }

    private function setPageTitle()
    {
        return $this->controller()->view->title = Yii::t('app', 'Search Panel - List of cases pending evidence review/determination');
    }

    /**
     * @param Record $model
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

    /**
     * @param string $name
     */
    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }

}
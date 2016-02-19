<?php

namespace app\modules\frontend\controllers\records;

use app\enums\Role;
use app\modules\frontend\models\base\Record;
use app\modules\frontend\models\base\RecordFilter;
use app\modules\frontend\Module;
use app\widgets\record\filter\Filter;
use Yii;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;

class SearchAction extends Action
{
    public $tab = 'search';
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

        $model = $this->loadModel();

        $provider = $model->search($this->attributes);

        $this->setAside($model, $user->hasRole([
            Role::ROLE_OPERATIONS_MANAGER,
            Role::ROLE_SYSTEM_ADMINISTRATOR,
            Role::ROLE_ROOT_SUPERUSER,
        ]));

        return $this->controller()->render(self::getView(), [
            'provider' => $provider,
        ]);
    }

    /**
     * @return string
     */
    private static function getView()
    {
        switch (Module::getTab()) {
            case 'search':
                return 'search/index';
            case 'review':
                return 'search/review';
            case 'print':
                return 'search/print';
            case 'update':
                return 'search/update';
            default:
                return 'search/error';
        }
    }

    /**
     * @return Record
     */
    private static function loadModel()
    {
        switch (Module::getTab()) {
            case 'search':
                return new \app\modules\frontend\models\search\Record;
            case 'review':
                return new \app\modules\frontend\models\review\Record;
            case 'print':
                return new \app\modules\frontend\models\prints\Record;
            case 'update':
                return new \app\modules\frontend\models\update\Record;
            default:
                return new Record();
        }
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
        $title = Yii::t('app', 'Search - implement me');

        switch ($this->tab) {
            case 'search':
                $title = Yii::t('app', 'Search Panel - List of uploaded cases');
                break;
            case 'update':
                $title = Yii::t('app', 'Search for a record to Update');
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
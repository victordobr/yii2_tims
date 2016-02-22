<?php

namespace app\modules\frontend\controllers\records;

use app\assets\PrintAsset;
use app\components\RbacUser;
use app\enums\MenuTab;
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
    public $qc = false;
    public $attributes;

    public function init()
    {
        parent::init();

        $this->setLayout('two-columns');
        if (Module::isCurrentTab(MenuTab::TAB_PRINT)) {
            PrintAsset::register($this->controller()->getView());
        }
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

        $this->setAside($model, $user);

        return $this->controller()->render($this->getViewName(), [
            'provider' => $provider,
        ]);
    }

    /**
     * @return string
     */
    private function getViewName()
    {
        switch (Module::getTab()) {
            case MenuTab::TAB_SEARCH:
                return 'search/index';
            case MenuTab::TAB_REVIEW:
                return 'search/review';
            case MenuTab::TAB_PRINT:
                return !$this->qc ? 'search/print' : 'search/qc';
            case MenuTab::TAB_UPDATE:
                return 'search/update';
            default:
                return 'search/error';
        }
    }

    /**
     * @return Record
     */
    private function loadModel()
    {
        switch (Module::getTab()) {
            case MenuTab::TAB_SEARCH:
                return new \app\modules\frontend\models\search\Record;
            case MenuTab::TAB_REVIEW:
                return new \app\modules\frontend\models\review\Record;
            case MenuTab::TAB_PRINT:
                return !$this->qc ?
                    new \app\modules\frontend\models\prints\Record:
                    new \app\modules\frontend\models\prints\qc\Record;
            case MenuTab::TAB_UPDATE:
                return new \app\modules\frontend\models\update\Record;
            default:
                return new Record();
        }
    }

    /**
     * @param RecordFilter $model
     * @param RbacUser $user
     * @return string
     * @throws \Exception
     */
    private function setAside(RecordFilter $model, RbacUser $user)
    {
        return Yii::$app->view->params['aside'] = Filter::widget([
            'model' => $model,
            'advanced_mode' => $user->hasRole([
                Role::ROLE_OPERATIONS_MANAGER,
                Role::ROLE_SYSTEM_ADMINISTRATOR,
                Role::ROLE_ROOT_SUPERUSER,
            ]),
        ]);
    }

    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    private function setPageTitle()
    {
        $title = Yii::t('app', 'Search - implement me');

        switch (Module::getTab()) {
            case MenuTab::TAB_SEARCH:
                $title = Yii::t('app', 'Search Panel - List of uploaded cases');
                break;
            case MenuTab::TAB_REVIEW:
                $title = Yii::t('app', 'Search Panel - List of cases pending evidence review/determination');
                break;
            case MenuTab::TAB_PRINT:
                $title =  !$this->qc ?
                    Yii::t('app', 'Search panel - List of cases pending print'):
                    Yii::t('app', 'Search panel - List of records to QC');
                break;
            case MenuTab::TAB_UPDATE:
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
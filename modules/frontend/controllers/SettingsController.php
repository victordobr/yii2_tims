<?php

/**
 * @link http://phe.me
 * @copyright Copyright (c) 2014 Pheme
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace app\modules\frontend\controllers;

use app\assets\AppAsset;
use app\assets\NotifyJsAsset;
use Yii;
use yii\filters\VerbFilter;
use app\models\Setting;
use app\modules\frontend\models\setting\Setting as SettingSearch;
use yii\helpers\ArrayHelper;


/**
 * SiteinfoController implements the CRUD actions for Setting model.
 *
 * @author Vitalii Fokov
 */
class SettingsController extends \pheme\settings\controllers\DefaultController
{
    public function init()
    {
        AppAsset::register($this->getView());
        NotifyJsAsset::register($this->getView());
        $this->setLayout('one-column');
        $this->setPageTitle();
    }

    /**
     * @param string $name
     */
    private function setLayout($name)
    {
        $this->layout = $name;
    }

    /**
     * @return string
     */
    private function setPageTitle()
    {
        $title = Yii::t('app', 'Settings');

        return $this->view->title = $title;
    }

    /**
     * Defines the controller behaviors
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Settings.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data = Setting::find()
            ->select('section')
            ->distinct()
            ->where(['<>', 'section', ''])
            ->asArray()
            ->all();
        $sectionsList = ArrayHelper::map($data, 'section', 'section');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sectionsList' => $sectionsList,
        ]);
    }

}



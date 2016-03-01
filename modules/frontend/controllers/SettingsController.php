<?php

/**
 * @link http://phe.me
 * @copyright Copyright (c) 2014 Pheme
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace app\modules\frontend\controllers;

use app\assets\AppAsset;
use app\assets\NotifyJsAsset;
use app\enums\Role;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Setting;
use app\modules\frontend\models\setting\Setting as SettingSearch;
use yii\helpers\ArrayHelper;


/**
 * SettingsController implements the CRUD actions for Setting model.
 *
 * @author Victor Dobrianskiy
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_SYSTEM_ADMINISTRATOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
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

    /**
     * Updates an existing Setting.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        else {
            return $this->render('update',[
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Setting.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

}



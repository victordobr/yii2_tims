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
use yii\web\NotFoundHttpException;
use \yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use app\models\Setting;
use app\modules\frontend\models\setting\Setting as SettingSearch;
use yii\helpers\ArrayHelper;
use yii\web\Response;


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
     * Creates a new Setting.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting(['active' => 1]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model,]);
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

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model,]);
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

    /**
     * Finds a Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (is_null($model = Setting::findOne($id))) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }

}



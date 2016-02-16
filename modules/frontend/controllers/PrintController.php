<?php

namespace app\modules\frontend\controllers;

use app\assets\PreviewAsset;
use app\assets\PrintAsset;
use app\enums\CaseStatus;
use app\enums\Role;
use app\widgets\record\filter\Filter;
use Yii;
use app\modules\frontend\base\Controller;
use app\modules\frontend\models\prints\Record;
use yii\filters\AccessControl;
use yii\web\Response;

class PrintController extends Controller
{
    public $layout = 'two-columns';

    public function beforeAction($action)
    {
        $view = $this->getView();
        switch ($action->id) {
            case 'preview':
                PreviewAsset::register($view);
                break;
            default:
                PrintAsset::register($view);
        }

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'preview', 'send', 'qc', 'confirm', 'reject'],
                'rules' => [
                    [
                        'actions' => ['index', 'preview', 'qc', 'send', 'confirm', 'reject'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_PRINT_OPERATOR,
                            Role::ROLE_OPERATIONS_MANAGER,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $user = Yii::$app->user;
        $model = new Record();

        $this->setPageTitle(Yii::t('app', 'Search panel - List of cases pending print'));
        $this->setAside($model, $user->hasRole([
            Role::ROLE_OPERATIONS_MANAGER,
            Role::ROLE_SYSTEM_ADMINISTRATOR,
            Role::ROLE_ROOT_SUPERUSER,
        ]));

        $provider = $model->search($request->get('Record'));


        return $this->render('index', [
            'dataProvider' => $provider,
        ]);
    }

    public function actionSend()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user_d = Yii::$app->user->id;
        $ids = Yii::$app->request->post('ids');

        $sent = [];
        foreach ($ids as $id) {
            !self::record()->sendToPrint($id, $user_d) || $sent[] = $id;
        }

        return $sent;
    }

    public function actionConfirm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user_d = Yii::$app->user->id;
        $ids = Yii::$app->request->post('ids');

        $confirmed = [];
        foreach ($ids as $id) {
            !self::record()->confirmQc($id, $user_d) || $confirmed[] = $id;
        }

        return $confirmed;
    }

    public function actionReject()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user_d = Yii::$app->user->id;
        $ids = Yii::$app->request->post('ids');

        $rejected = [];
        foreach ($ids as $id) {
            !self::record()->rejectQc($id, $user_d) || $rejected[] = $id;
        }

        return $rejected;
    }

    public function actionPreview()
    {
        $this->layout = 'preview';
        $model = new Record;
        $dataProvider = $model->preview(Yii::$app->request->queryParams);

        return $this->render('preview', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionQc()
    {
        $request = Yii::$app->request;
        $user = Yii::$app->user;
        $model = new Record();

        $this->setPageTitle(Yii::t('app', 'Search panel - List of records to QC'));
        $this->setAside($model, $user->hasRole([
            Role::ROLE_OPERATIONS_MANAGER,
            Role::ROLE_SYSTEM_ADMINISTRATOR,
            Role::ROLE_ROOT_SUPERUSER,
        ]));

        $provider = $model->search($request->get('Record'));

        return $this->render('qc', [
            'dataProvider' => $provider,
        ]);
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
     * @param string $title
     * @return string
     */
    private function setPageTitle($title)
    {
        return $this->view->title = $title;
    }

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

}
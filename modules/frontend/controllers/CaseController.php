<?php
namespace app\modules\frontend\controllers;

use app\enums\Role;
use app\models\PoliceCase;
use app\models\Reason;
use app\modules\frontend\models\form\DeactivateForm;
use yii\filters\AccessControl;
use \app\modules\frontend\base\Controller;

use \Yii;
use yii\web\NotFoundHttpException;

class CaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['review', 'deactivate'],
                'rules' => [
                    [
                        'actions' => ['review'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_VIDEO_ANALYST,
                            Role::ROLE_VIDEO_ANALYST_SUPERVISOR,
                            Role::ROLE_POLICE_OFFICER,
                            Role::ROLE_POLICE_OFFICER_SUPERVISOR,
                            Role::ROLE_PRINT_OPERATOR,
                            Role::ROLE_OPERATION_MANAGER,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                    [
                        'actions' => ['deactivate'],
                        'allow' => true,
                        'roles' => [
                            Role::ROLE_VIDEO_ANALYST,
                            Role::ROLE_VIDEO_ANALYST_SUPERVISOR,
                            Role::ROLE_ROOT_SUPERUSER
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionReview($id = 0)
    {
        if (!$id) {
            $this->redirect(['data/search']);
        }

        return $this->render('view', [
            'model' => $this->findModel(PoliceCase::className(), $id),
        ]);
    }

    public function actionDeactivate($id)
    {
        $request = Yii::$app->request;
        $case = $this->findModel(PoliceCase::className(), $id);

        $form = new DeactivateForm();
        $form->setAttributes($request->post('DeactivateForm'));

        if ($form->validate() && $case->deactivate()) {
            $reason = new Reason();
            $reason->setAttributes($form->getAttributes());
            $reason->save();

            return $this->redirect(['data/search']);
        }

        return $this->redirect(['review', 'id' => $case->id]);
    }

    /**
     * @param string|\yii\db\ActiveRecord $modelClass
     * @param int $id
     * @return null|PoliceCase
     * @throws NotFoundHttpException
     */
    protected function findModel($modelClass, $id)
    {
        if (($model = PoliceCase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
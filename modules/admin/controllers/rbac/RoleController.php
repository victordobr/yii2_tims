<?php namespace app\modules\admin\controllers\rbac;

use Yii;
use app\enums\Role;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RoleController extends \johnitvn\rbacplus\controllers\RoleController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Role::ROLE_ROOT_SUPERUSER],
                    ],
                ],
            ],
        ]);
    }

    public function actionDelete($name)
    {
        $request = Yii::$app->request;
        $this->findModel($name)->delete();

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose' => true,
                'forceReload' => '#crud-datatable-pjax'
            ];
        }

        return $this->redirect(['index']);
    }

    protected function findModel($name)
    {
        if (($model = \app\modules\admin\models\rbac\Role::find($name)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('rbac', 'The requested page does not exist.'));
        }
    }

}
<?php
namespace app\base;

use \Yii;
use \yii\db\ActiveRecord;
use \yii\web\Response;
use \yii\helpers\Json;
use \yii\widgets\ActiveForm;
use \yii\web\NotFoundHttpException;
use \app\enums\UserType;

/**
 * Application base controller.
 * @package app\base\Controller
 */
class Controller extends \yii\web\Controller
{
    /**
     * Perform ajax validation.
     * @param \app\base\ActiveRecord $model model for validate.
     * @return array the error message array indexed by the attribute IDs.
     * @author Alex Makhorin
     */
    protected function performAjaxValidation(&$model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            echo Json::encode(ActiveForm::validate($model));
            Yii::$app->end();
        }
    }

    /**
     * Finds the Attractor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string|ActiveRecord $modelClass model or model class.
     * @param integer $id model id.
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     * @author Alex Makhorin
     */
    protected function findModel($modelClass, $id)
    {
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string cabinet actions.
     * @throws NotFoundHttpException
     * @author Alex Makhorin
     */
    public function cabinetAction()
    {
        // switch (true) {
        //     case Yii::$app->user->isGuest :
        //         $result = '/';
        //         break;
        //     case (Yii::$app->user->identity->type_id == UserType::ADMIN) :
        //         $result = Yii::$app->params['url.cabinet.admin'];
        //         break;
        //     case (Yii::$app->user->identity->type_id == UserType::CLIENT) :
        //         $result = Yii::$app->params['url.cabinet.client'];
        //         break;
        //     default:
        //         throw new NotFoundHttpException();
        // }

        // return $result;

        return '/';
    }
}
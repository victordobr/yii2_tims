<?php


namespace app\modules\frontend\controllers;


use yii\filters\AccessControl;
use \app\modules\frontend\base\Controller;
use \app\models\User;
use \app\models\forms\Password as PasswordForm;

use \Yii;
use \yii\filters\VerbFilter;
use \yii\base\Exception;
use \yii\web\HttpException;
use \yii\helpers\Url;

/**
 * Class DefaultController
 * @package app\modules\frontend\controllers
 * @author Alex Makhorin
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['welcome'],
                'rules' => [
                    [
                        'actions' => ['welcome'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * @return string
     */
    public function actionWelcome()
    {
        return $this->render('welcome');
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'manage' page.
     * @return mixed
     * @author Alex Makhorin
     */
    public function actionProfile()
    {
//        $this->layout = 'middle.php';
        $userId = Yii::$app->user->identity->getId();

        /** @var \app\models\User $model */
        $model = $this->findModel(User::className(), $userId);
        $model->load(Yii::$app->request->post()) && $model->save();

        $view = 'profile';
        $params = [
            'model' => $model,
            'passwordForm' => new PasswordForm(),
        ];

        return Yii::$app->request->isAjax ? $this->renderAjax($view, $params) : $this->render($view, $params);
    }

    /**
     * Action change user password.
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     * @author Alex Makhorin
     */
    public function actionChangePassword()
    {
        /** @var User $model */
        $model = $this->findModel(User::className(), Yii::$app->user->identity->getId());
        $passwordForm = new PasswordForm();

        if ($passwordForm->load(Yii::$app->request->post())) {
            $passwordForm->userId = Yii::$app->user->identity->getId();

            if ($passwordForm->validate()) {
                $model->password = $passwordForm->new;
                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success', ['body' => Yii::t('app', 'Password changed')]);
                    return $this->redirect(['profile']);
                } else {
                    Yii::$app->getSession()->setFlash('danger', ['body' => Yii::t('app', 'Password not changed')]);
                    return $this->redirect(['profile']);
                }
            }
        }

        return $this->renderAjax('partials/_changePasswordModal', ['model' => $passwordForm]);
    }

}
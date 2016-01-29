<?php

namespace app\modules\auth\controllers;

use app\enums\Role;
use Yii;
use yii\filters\AccessControl,
    yii\filters\VerbFilter,
    yii\web\HttpException;
//use app\base\Controller;
use yii\web\Controller;
use app\modules\auth\models\mappers\classes\UserIdentity as User,
    app\modules\auth\models\forms\Login,
    app\modules\auth\models\forms\Forgot,
    app\modules\auth\models\forms\Recover;
use app\modules\auth\models\forms\Answer;

/**
 * Controller class. Implements default auth functionality.
 * @package app\modules\auth\controllers
 */
class DefaultController extends Controller
{

    const HASH_PARAM_NAME = 'hash';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Action login.
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->actionCabinet();
        }

        $model = new Login();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->actionCabinet();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Action logout.
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionForgot()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect($this->cabinetAction());
        }

        $model = new Forgot();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $recoverHash = Yii::$app->security->generateRandomString();

            $rowsUpdated = User::updateAll(['recover_hash' => $recoverHash], 'email = :email', [':email' => $model->email]);

            if ($rowsUpdated === 0) {
                throw new HttpException(500, Yii::t('app', 'Database error'));
            }

            $recoveryUrl = \yii\helpers\Url::to(['recover', self::HASH_PARAM_NAME => $recoverHash], true);

            $isSent = Yii::$app->mailer->compose('user_recoverPassword', ['recoveryUrl' => $recoveryUrl])
                ->setTo($model->email)
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['adminFrom']])
                ->setSubject(Yii::t('app', 'Password recovery'))
                ->send();

            if (!$isSent) {
                throw new HttpException(500, Yii::t('app', 'Email sending error occurred'));
            }

            $alert = \yii\bootstrap\Alert::widget([
                'options' => [
                    'class' => 'alert-success',
                ],
                'body' => Yii::t('app', 'Email with further instructions was sent'),
            ]);

            Yii::$app->getSession()->setFlash('success', $alert);
        }

        return $this->render('forgot', [
            'model' => $model,
        ]);
    }

    public function actionRecover()
    {
        $recoverHash = Yii::$app->request->get(self::HASH_PARAM_NAME);
        if (!$recoverHash) {
            throw new HttpException(400, Yii::t('app', 'Bad security code'));
        }

        $user = User::find()->where(['recover_hash' => $recoverHash])->one();
        if (!$user) {
            throw new HttpException(400, Yii::t('app', 'Bad security code'));
        }

        $cookies = Yii::$app->request->cookies;
        $answerCookie = $cookies->getValue('answer');

        if ($user->question_id && $user->question_answer && !$answerCookie) {

            $answerModel = new Answer();

            $question = $user->question->text;
            $answer = false;
            if ($answerModel->load(Yii::$app->request->post()) && $answerModel->validate()) {
                if ($user->question_answer == $answerModel->answer) {
                    $answer = true;
                    $cookies = Yii::$app->response->cookies;
                    $cookies->add(new \yii\web\Cookie([
                        'name' => 'answer',
                        'value' => $answer,
                    ]));
                }
                else {
                    $alert = \yii\bootstrap\Alert::widget([
                        'options' => [
                            'class' => 'alert-danger',
                        ],
                        'body' => Yii::t('app', 'The answer is not correct!'),
                    ]);
                    Yii::$app->getSession()->setFlash('danger', $alert);
                }
            }
            if ($answer == false) {
                return $this->render('answer', [
                    'questions' => $question,
                    'model' => $answerModel,
                ]);
            }
        }

        $model = new Recover();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->password = $model->password;
            $user->recover_hash = null;
            $user->save(false);

            $alert = \yii\bootstrap\Alert::widget([
                'options' => [
                    'class' => 'alert-success',
                ],
                'body' => Yii::t('app', 'Password was changed successfully. You can use it for login'),
            ]);

            Yii::$app->getSession()->setFlash('success', $alert);
        }

        return $this->render('recover', [
            'model' => $model,
        ]);
    }

    public function actionActivation()
    {
        $activationHash = Yii::$app->request->get(self::HASH_PARAM_NAME);

        $user = User::find()->where(['activation_hash' => $activationHash])->one();

        if (!$user) {
            throw new HttpException(400, Yii::t('app', 'Bad security code'));
        }

        $user->activation_hash = null;
        $complete = $user->save(false);

        $alert = \yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::t('app', 'Activation finished successfully. You can log in now'),
        ]);

        if($complete) {
            Yii::$app->getSession()->setFlash('successActivation', $alert);
        }

        return $this->render('activation', [
        ]);

    }

    /**
     * User Cabinet
     * @return \yii\web\Response
     */
    public function actionCabinet()
    {
        if (\app\models\User::hasRole(Role::ROLE_SYSTEM_ADMINISTRATOR) || \app\models\User::hasRole(Role::ROLE_ROOT_SUPERUSER)) {
            return $this->redirect(Yii::$app->params['url.admin.default']);
        }

        return $this->redirect(Yii::$app->params['url.frontend.default']);
    }
}

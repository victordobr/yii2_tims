<?php

namespace app\modules\admin\controllers;

use app\enums\Role;
use \Yii;
use yii\filters\AccessControl;
use \yii\filters\VerbFilter;
use \yii\base\Exception;
use \yii\web\HttpException;
use \yii\helpers\Url;

use \app\modules\admin\base\Controller;
use \app\modules\admin\models\search\User as UserSearch;
use \app\models\forms\Password as PasswordForm;
use \app\models\User;
use \app\controllers\actions\Suggestions;

use \dosamigos\grid\ToggleAction;

/**
 * UsersController implements the CRUD actions for User model.
 * @package app\modules\admin\controllers
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['manage', 'view', 'create', 'update', 'delete', 'profile', 'changeEmail', 'changePassword'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Role::ROLE_ROOT_SUPERUSER],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'toggle'     => [
                'class'      => ToggleAction::className(),
                'modelClass' => User::className(),
                'onValue'    => User::STATUS_ACTIVE,
                'offValue'   => User::STATUS_NOT_ACTIVE
            ],
            'suggestion' => [
                'class' => Suggestions::className(),
            ]
        ];
    }

    public function actionManage()
    {
//        $userService = Yii::$app->get('service|user');
//        $model = $userService->getModel(UserSearch::className());
        $model = new UserSearch();

        return $this->render('manage', [
            'dataProvider'      => $model->search(Yii::$app->request->get()),
            'model'             => $model,
            'autoCompleteLimit' => 3,
            'userList'          => \app\models\User::getUserList(),
            'modelCode'         => \app\modules\admin\models\search\User::className(),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws HttpException
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'middle.php';
//        $model = new User(['scenario' => User::SCENARIO_REGISTER]);
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            try {
                Yii::$app->user->createUser($model->attributes);
                return $this->redirect(['manage']);
//            } catch (Exception $e) {
//                throw new HttpException(500, $e->getMessage());
//            }
        } else {

//            var_dump($model->getErrors()); die;

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'manage' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'middle.php';
        $model = $this->findModel(User::className(), $id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['manage']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'manage' page.
     * @param integer $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->get('service|user')->haveDeletePermission($id)) {
            throw new HttpException(403, Yii::t('app', 'You can\'t to delete your account and master account!'));
        }
        Yii::$app->get('service|user')->deleteUser($id);

        return $this->redirect(['manage']);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'manage' page.
     * @return mixed
     */
    public function actionProfile()
    {
        $this->layout = 'middle.php';
        $userId = Yii::$app->user->identity->getId();

        /** @var \app\models\User $model */
        $model = $this->findModel(User::className(), $userId);
        $model->load(Yii::$app->request->post()) && $model->save();
        $allRacks = $model->getRacks()->count();
        $usedSpace = Yii::$app->get('service|gallery')->getUsedSpace($userId);

        $view = 'profile';
        $params = [
            'model'        => $model,
            'allRacks'     => $allRacks,
            'usedSpace'    => $usedSpace,
            'passwordForm' => new PasswordForm(),
        ];

        return Yii::$app->request->isAjax ? $this->renderAjax($view, $params) : $this->render($view, $params);
    }

    /**
     * Action change user email.
     * @return string|\yii\web\Response
     * @throws HttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionChangeEmail()
    {
        if (empty(Yii::$app->request->post('User')['email'])) {
            throw new HttpException(400, 'Bad request!');
        }

        /** @var User $model */
        $model = $this->findModel(User::className(), Yii::$app->user->identity->getId());
        $model->email = Yii::$app->request->post('User')['email'];
        if ($model->isChanged('email')) {
            $model->activation_hash = Yii::$app->security->generateRandomString();
            $transaction = Yii::$app->db->beginTransaction();
            if ($model->save()) {
                $activationUrl = Url::to([
                    '/auth/default/activation',
                    UserService::HASH_PARAM_NAME => $model->activation_hash
                ], true);

                $mail = Yii::$app->mailer
                    ->compose('user_changeEmail', [
                        'login'         => $model->email,
                        'activationUrl' => $activationUrl,
                    ])
                    ->setTo($model->email)
                    ->setFrom([Yii::$app->params['admin.email'] => Yii::$app->params['admin.alias']])
                    ->setSubject(Yii::t('app', 'TIMS - Change Email'));

                if (!$mail->send()) {
                    $transaction->rollBack();
                    throw new HttpException(500, Yii::t('app', 'Email sending error occurred'));
                } else {
                    $transaction->commit();
                    return $this->redirect('/logout');
                }
            }
            $transaction->rollBack();
        }

        return $this->renderAjax('partials/_changeEmailModal', ['model' => $model]);
    }

    /**
     * Action change user password.
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
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

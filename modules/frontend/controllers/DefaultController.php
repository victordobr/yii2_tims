<?php


namespace app\modules\frontend\controllers;


use yii\filters\AccessControl;
use \app\modules\frontend\base\Controller;

/**
 * Class DefaultController
 * @package app\modules\frontend\controllers
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

}